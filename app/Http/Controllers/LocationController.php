<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function index(){
        $locations = Location::orderBy('id','desc')->get();
        return view('pages.vehicles.locations.index', compact('locations'));
    }

    public function store(Request $request){
        try{
            $location_id = $request->location_id;
            $name = $request->name;
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $location = Location::find($location_id);
            if(!$location)
                $location = new Location();
            $location->name = $name;
            $location->latitude = $latitude;
            $location->longitude = $longitude;
            $location->save();
            return back()->with('success', 'Location saved successfully');
        }catch (\Exception $e){
            return back()->with('error', 'error has occur');
        }
    }

    public function destroy(Location $location){
        try{
            $location->delete();
            return back()->with('success', 'Record deleted');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete this record');
        }
    }
}
