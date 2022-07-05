<?php

namespace App\Http\Controllers;

use App\Models\InventorySupplier;
use Illuminate\Http\Request;

class InventorySupplierController extends Controller
{
    //
    public function index(){
        $suppliers = InventorySupplier::orderBy('name', 'asc')->get();
        return view('pages.inventory.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request){
        try{
            $supplier_id = $request->supplier_id;
            $supplier = InventorySupplier::find($supplier_id);
            if(!$supplier)
                $supplier = new InventorySupplier();
            if(!$supplier_id)
                $supplier->code = InventorySupplier::getNewCode();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->status = InventorySupplier::STATUS_ACTIVE;
            $supplier->save();
            return back()->with('success', 'Supplier record deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy(InventorySupplier $supplier){
        try{
            $supplier->delete();
            return back()->with('success', 'Supplier record deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete supplier');
        }
    }
}
