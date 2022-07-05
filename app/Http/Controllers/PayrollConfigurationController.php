<?php

namespace App\Http\Controllers;

use App\Models\PayrollItem;
use Illuminate\Http\Request;

class PayrollConfigurationController extends Controller
{
    //
    public function items(){
        $items = PayrollItem::orderBy('name', 'asc')->get();
        return view('pages.payroll.configurations.items', compact('items'));
    }

    public function itemsStore(Request $request){
        try{
            $item_id = $request->item_id;
            $item = PayrollItem::find($item_id);
            if(!$item)
                $item = new PayrollItem();
            $item->code = $request->code;
            $item->name = $request->name;
            $item->type = $request->type;
            $item->status = $request->status;
            $item->save();
            return back()->with('success', 'Done successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }
}
