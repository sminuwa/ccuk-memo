<?php

namespace App\Http\Controllers;

use App\Models\InventoryUnit;
use Illuminate\Http\Request;

class InventoryUnitController extends Controller
{
    //
    public function index()
    {
        $units = InventoryUnit::orderBy('name', 'asc')->get();
        return view('pages.inventory.configurations.units.index', compact('units'));
    }

    public function store(Request $request)
    {
        try{
            $unit_id = $request->unit_id;
            $unit = InventoryUnit::find($unit_id);
            if(!$unit)
                $unit = new InventoryUnit();
            $unit->name = $request->name;
            $unit->code = $request->code;
            $unit->base_unit = $request->base_unit;
            $unit->operator = $request->operator;
            $unit->operation_value = $request->operation_value;
            $unit->save();
            return back()->with('success', 'Unit has been added successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy(InventoryUnit $unit){
        try{
            $unit->delete();
            return back()->with('success', 'Your record has been deleted');
        }catch (\Exception $e){
            return back()->with('error', 'Your record cannot be deleted');
        }
    }
}
