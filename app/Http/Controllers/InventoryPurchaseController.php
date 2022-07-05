<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\InventoryItem;
use App\Models\InventoryPurchase;
use Illuminate\Http\Request;

class InventoryPurchaseController extends Controller
{
    //
    public function index(){
        $purchases = InventoryPurchase::orderBy('id', 'desc')->get();
        $items = InventoryItem::orderBy('name','asc')->get();
        $branches = Branch::orderBy('name','asc')->get();
        return view('pages.inventory.purchases.index', compact('purchases','items','branches'));
    }

    public function store(Request $request){
        try{
            $supply_id = $request->supply_id;
            $supply = InventoryPurchase::find($supply_id);
            if(!$supply)
                $supply = new InventoryPurchase();
            $supply->branch_id = $request->branch_id;
            $supply->item_id = $request->item_id;
            $supply->batch_number = $request->batch_number;
            $supply->quantity = $request->quantity;
            $supply->unit_price = $request->unit_price;
            $supply->date = $request->date;
            $supply->expiry = $request->expiry;
            $supply->save();
            return back()->with('success', 'Your supply record saved successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(InventoryPurchase $supply){
        try{
            $supply->delete();
            return back()->with('success', 'Your supply record had been deleted');
        }catch (\Exception $e){
            return back()->with('error', 'Your supply record cannot be deleted');
        }
    }
}
