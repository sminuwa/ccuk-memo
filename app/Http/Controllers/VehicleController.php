<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Models\VehicleDispatch;
use App\Models\VehicleDriver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;


/**
 * Description of VehicleController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class VehicleController extends Controller
{

    public function index()
    {
    	$vehicles = Vehicle::orderBy('name','asc')->get();
        return view('pages.vehicles.vehicles.index', compact('vehicles'));
    }

    public function show(Request $request, Vehicle $vehicle)
    {
        return view('pages.vehicles.vehicles.show',compact('vehicle'));
    }

    public function create(){
        return view('pages.vehicles.vehicles.create');
    }

    public function store(Request $request)
    {
        $code = $request->code;
        $number = $request->number;
        $cassis = $request->cassis;
        $category = $request->category;
        $type = $request->type;
        $cost = str_replace(',','', $request->cost);
        $date_purshased = $request->date_purchased;
        $new_second = $request->new_second;
        $name = $request->name;
        $model = $request->model;
        $fuel = $request->fuel;
        $tonnage = $request->tonnage;
        $color = $request->color;
        try{
            $vehicle = new Vehicle();
            $vehicle->code = $code;
            $vehicle->name = $name;
            $vehicle->color = $color;
            $vehicle->model = $model;
            $vehicle->cassis = $cassis;
            $vehicle->number = $number;
            $vehicle->fuel = $fuel;
            $vehicle->new_second = $new_second;
            $vehicle->date_purchased = $date_purshased;
            $vehicle->cost = $cost;
            $vehicle->category = $category;
            $vehicle->type = $type;
            $vehicle->tonnage = $tonnage;
            $vehicle->status = Vehicle::STATUS_IDLE;
            $vehicle->save();
            return redirect(route('vehicles.vehicles.show', $vehicle->id))->with('success', 'New vehicle added successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function select2Search(Request $request){
        $result = [];
        $vehicles = Vehicle::where('number','like', '%'.$request->search.'%')->get();
        foreach($vehicles as $vehicle){
            $result[] = ["text"=>$vehicle->number,"id"=>$vehicle->id];
        }
        return $result;
    }

    public function changeDriver(Request $request, Vehicle $vehicle){
        //check if there is active driver
        try{
            $active = VehicleDriver::where(['vehicle_id'=>$vehicle->id, 'status'=>VehicleDriver::STATUS_ACTIVE])->first();
            $date_to = now()->toDateTimeString();
            if($active) {
                $active->to_date = $date_to;
                $active->status = VehicleDriver::STATUS_INACTIVE;
                $active->save();
            }
            $driver = new VehicleDriver();
            $driver->vehicle_id = $vehicle->id;
            $driver->user_id = $request->driver_name;
            $driver->from_date = $date_to;
            $driver->to_date = null;
            $driver->status = VehicleDriver::STATUS_ACTIVE;
            $driver->save();
            return back()->with('success', 'Driver updated for this vehicle');
        }catch (\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function destroy(Vehicle $vehicle){
        try{
            $vehicle->delete();
            return back()->with('success', 'Vehicle has been deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete vehicle');
        }
    }

    public function closeDispatch(VehicleDispatch $dispatch){
        try{
            $dispatch->date_to = now()->toDateTimeString();
            $dispatch->save();
            $vehicle = $dispatch->driver->vehicle;
            $vehicle->status = Vehicle::STATUS_IDLE;
            $vehicle->save();
            return back()->with('success', 'Dispatch closed successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot close this dispatch');
        }
    }

    public function forms(Vehicle $vehicle){
        $locations = Location::orderBy('name','desc')->get();
        return view('pages.vehicles.vehicles.forms', compact('vehicle'));
    }

}
