<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Helpers\SearchFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\baseControllers\BaseController;

class UserController extends BaseController
{
    protected $searchableField = ['name', 'email'];

    public function index()
    {
        $r = request()->all();
        $q = $r['q'] ?? '';

        $model = SearchFilter::filterd(new User, $this->searchableField, true);
        $records = $model->withTrashed()->orderBy('id', 'desc')->paginate(20);
        $records = SearchFilter::customPaginate($records, $r);

        return view('users.index', ['data' => $records, 'q' => $q]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:25', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required'],
        ]);

        $data = $request->all();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('users.index')->with('message','Successfully create');
    }

    public function edit($id)
    {
        if(Auth::id() != $id) {
            return redirect()->back();
        }
        $records = User::find($id);
        return view('users.edit',['data' => $records]);
    }

    public function update(Request $request,$id)
    {
        if(Auth::id() != $id) {
            return redirect()->back();
        }
        $data = $request->all();
        $records = User::find($id);

        if($records->username != $data['username']){
            $request->validate([
                'username' => ['required', 'string', 'max:25', 'unique:users'],
            ]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:50']
        ]);

        if($data['password']){
            $request->validate([
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
        }

        $records->update([
            'name' => $data['name'],
            'username' => $data['username'],
        ]);

        if($data['password']){
            $records->password = Hash::make($data['password']);
            $records->save();
        }

        if($request->file('avatar')){
            $file = $request->file('avatar');
            $path = time().$file->getClientOriginalName();
            $destinationPath = 'uploads';
            $file->move($destinationPath,$path);

            $records->avatar = $path;
            $records->save();
        }
        return redirect()->route('users.index')->with('message','Successfully update');
    }

    public function destroy($id)
    {
        $user = User::withTrashed()->find($id);
        if($user->deleted_at){
            $user->restore();
            $message = "User activate";
        }else{
            $user->delete();
            $message = "User disabled";
        }
		return redirect()->route('users.index')->with('message', $message);;
    }
}
