<?php

namespace App\Http\Controllers;

use App\Models\FuelPrice;
use Illuminate\Http\Request;

class FuelPriceController extends Controller
{
    //
    public function index(){
        $fuels = FuelPrice::orderBy('id', 'desc')->get();
        return view('pages.vehicles.fuel-prices.index', compact('fuels'));
    }

    public function store(Request $request){
        try{
            $now = now()->toDateTimeString();
            $fuel_id = $request->fuel_id;
            $name = $request->name;
            $price = $request->price;
            $term = $request->term;
            $fuel = FuelPrice::find($fuel_id);
            if(!$fuel) {
                FuelPrice::where(['date_to'=> null,'name'=>$name])->update(['date_to'=>$now]);
                $fuel = new FuelPrice();
                $fuel->date_from = $now;
            }
            $fuel->name = $name;
            $fuel->price = $price;
            $fuel->term = $term;
            $fuel->save();
            return back()->with('success', 'Configured successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(FuelPrice $fuelPrice){
        try{
            $fuelPrice->delete();
            return back()->with('success', 'Fuel price deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete the fuel price');
        }
    }

}
