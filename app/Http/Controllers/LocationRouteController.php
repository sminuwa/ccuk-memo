<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationRoute;
use App\Models\Route;
use Illuminate\Http\Request;

class LocationRouteController extends Controller
{
    public function index(){
        $locationRoutes = LocationRoute::all();
        $routes = Route::all();
        $locations = Location::all();
        return view('pages.vehicles.location-routes.index', compact('locationRoutes','routes', 'locations'));
    }

    public function store(Request $request){
        try{
            $location_route_id = $request->location_route_id;
            $location_from = $request->location_from;
            $location_to = $request->location_to;
            $route_id = $request->route_id;
            $distance = $request->distance;
            $locationRoute = LocationRoute::find($location_route_id);
            if(!$locationRoute)
                $locationRoute = new LocationRoute();
            $locationRoute->location_from = $location_from;
            $locationRoute->location_to = $location_to;
            $locationRoute->route_id = $route_id;
            $locationRoute->distance = $distance;
            $locationRoute->save();
            return back()->with('success', 'Location route saved successfully');
        }catch (\Exception $e){
            return back()->with('error', 'error has occur');
        }
    }

    public function destroy(LocationRoute $locationRoute){
        try{
            $locationRoute->delete();
            return back()->with('success', 'Location route deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete location route');
        }
    }
}
