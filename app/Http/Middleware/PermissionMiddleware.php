<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PermissionMiddleware
{

    public function handle($request, Closure $next, ...$permissions_array)
    {
        foreach($permissions_array as $permission){
            if (!$request->user()->canAccess($permission)){
                return back()->with('error', 'You are not allowed to access the intended page');
            }
        }
        return $next($request);
    }
    /*
    public function handle(Request $request, Closure $next)
    {
//        Route::
        //return response(Route::currentRouteName());//;
        //$user = Auth::user();
        return $next($request);
    }*/
}
