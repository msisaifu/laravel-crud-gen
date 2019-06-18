<?php

namespace App\Http\Controllers\baseControllers;

use Illuminate\Http\Request;
use App\Helpers\SearchFilter;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $searchableField;
    protected $model;
    protected $route;

    protected function index()
    {
        $records = SearchFilter::filterd(new $this->model, $this->searchableField);
        return view("{$this->route}.index", $records);
    }

    protected function create()
    {
        return view("{$this->route}.create");
    }

    protected function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50']
        ]);

        $this->model::create($request->all());
        return redirect()->route("{$this->route}.index")->with('message','Successfully create');
    }

    protected function edit($id)
    {
        $record = $this->model::findOrFail($id);
        return view("{$this->route}.edit",['data' => $record]);
    }

    protected function update(Request $request, $id)
    {
        $record = $this->model::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:50']
        ]);

        $record->update($request->all());
        return redirect()->route("{$this->route}.index")->with('message','Successfully update');
    }

    protected function destroy($id)
    {
        $record = $this->model::findOrFail($id);
        $record->delete();
        return redirect()->route("{$this->route}.index")->with('message', "Successfully deleted");;
    }
}