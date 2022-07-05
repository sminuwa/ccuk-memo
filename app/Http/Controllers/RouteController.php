<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(){
        $routes = Route::all();
        return view('pages.vehicles.routes.index', compact('routes'));
    }

    public function store(Request $request){
        try{
            $route_id = $request->route_id;
            $name = $request->name;
            $direction = $request->direction;
            $route = Route::find($route_id);
            if(!$route)
                $route = new Route();
            $route->name = $name;
            $route->direction = $direction;
            $route->save();
            return back()->with('success', 'Route saved successfully');
        }catch (\Exception $e){
            return back()->with('error', 'error has occur');
        }
    }

    public function destroy(Route $route){
        try{
            $route->delete();
            return back()->with('success','Route deleted successfully');
        }catch (\Exception $e){
            return back()->with('error','Route cannot be deleted.');
        }
    }
}
