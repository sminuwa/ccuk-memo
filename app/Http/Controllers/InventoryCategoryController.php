<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
{
    //
    public function index(){
        $categories = InventoryCategory::orderBy('name', 'asc')->get();
        return view('pages.inventory.configurations.categories.index', compact('categories'));
    }

    public function store(Request $request){
        try{
            $category_id = $request->category_id;
            $name = $request->name;
            $category = InventoryCategory::find($category_id);
            if(!$category)
                $category = new InventoryCategory();
            $category->name = $name;
            $category->save();
            return back()->with('success', 'Category saved successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function destroy(InventoryCategory $category){
        try{
            $category->delete();
            return back()->with('success', 'Category deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Your record cannot be deleted');
        }
    }
}
