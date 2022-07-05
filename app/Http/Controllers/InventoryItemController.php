<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryUnit;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    //
    public function index(){
        $items = InventoryItem::orderBy('code', 'desc')->get();
        $categories = InventoryCategory::orderBy('name', 'asc')->get();
        $branches = Branch::orderBy('name','asc')->get();
        $units = InventoryUnit::orderBy('name','asc')->get();
        return view('pages.inventory.configurations.items.index', compact('items','categories','branches','units'));
    }

    public function create(){
        $categories = InventoryCategory::orderBy('name', 'asc')->get();
        $branches = Branch::orderBy('name','asc')->get();
        $units = InventoryUnit::orderBy('name','asc')->get();
        return view('pages.inventory.configurations.items.create',compact('categories','branches','units'));
    }

    public function store(Request $request){
        try{
            $item_id = $request->item_id;
            $item = InventoryItem::find($item_id);
            if(!$item)
                $item = new InventoryItem();
            if(!$item_id)
                $item->code = InventoryItem::getCode();
            $item->name = $request->name;
            $item->category_id = $request->category_id;
            $item->unit = $request->unit;
            $item->brand = $request->brand;
            $item->alert_quantity = $request->alert_quantity;
            $item->save();
            return back()->with('success', 'Inventory item added successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(InventoryItem $item){
        try{
            $item->delete();
            return back()->with('success','Record has been deleted');
        }catch (\Exception $e){
            return back()->with('error', 'Error while deleting your record');
        }
    }
}
