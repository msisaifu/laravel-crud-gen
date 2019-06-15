<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use App\Helpers\Access;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $curdDef = [
            'c' => ['create', 'store'],
            'r' => ['index', 'view'],
            'u' => ['edit', 'update'],
            'd' => ['delete'],
        ];

        $routeName = $request->route()->getName();
        $role = Auth::user()->role;
        $access = Access::access($role, 'P');
        $isAccessbile = in_array(ucfirst($routeName), $access);

        if(!$isAccessbile){
            $explodeRoute = explode('.', $routeName);
            $aRoute = ucfirst($explodeRoute[0]);
            $isAccessbile = in_array($aRoute, $access);

            if(!$isAccessbile){
                foreach($access as $val){
                    if(strpos($val, "@")){
                        $rRoute = explode("@", $val);
                        $aRoute = str_split($rRoute[1]);
                        $aArr = [];
                        foreach($aRoute as $val){
                            if(array_key_exists($val, $curdDef)){
                                $a = array_values($curdDef[$val]);
                                foreach($a as $v){
                                    array_push($aArr, strtolower($rRoute[0]).".".$v);
                                }
                            }
                        }
                    }
                }
                $isAccessbile = in_array($routeName, $aArr);
            }
        }

        if (!$isAccessbile) {
            abort(404);
        }
        return $next($request);
    }
}
