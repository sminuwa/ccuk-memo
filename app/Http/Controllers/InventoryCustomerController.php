<?php

namespace App\Http\Controllers;

use App\Models\InventoryCustomer;
use Illuminate\Http\Request;

class InventoryCustomerController extends Controller
{
    //
    public function index(){
        $customers = InventoryCustomer::orderBy('name', 'asc')->get();
        return view('pages.inventory.customers.index', compact('customers'));
    }

    public function store(Request $request){
        try{
            $customer_id = $request->customer_id;
            $customer = InventoryCustomer::find($customer_id);
            if(!$customer)
                $customer = new InventoryCustomer();
            if(!$customer_id)
                $customer->code = InventoryCustomer::getNewCode();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->status = InventoryCustomer::STATUS_ACTIVE;
            $customer->save();
            return back()->with('success', 'Customer record deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy(InventoryCustomer $customer){
        try{
            $customer->delete();
            return back()->with('success', 'Customer record deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete customer');
        }
    }
}
