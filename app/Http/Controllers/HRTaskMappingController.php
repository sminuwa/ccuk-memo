<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\HrTaskMapping;
use Illuminate\Http\Request;

class HRTaskMappingController extends Controller
{
    //
    public function index(){
        $branches = Branch::with('hr_mapping','staff')->orderBy('name', 'asc')->get();
        $mappings = HrTaskMapping::all();
        return view('pages.hr.tasks.mappings.index', compact('branches', 'mappings'));
    }

    public function store(Request $request){

    }

    public function unit($unit_id){
        $unit = Branch::with('hr_mapping','staff')->where('id', $unit_id)->first();
        $mappings = HrTaskMapping::where('branch_id', $unit_id)->orderBy('id','desc')->get();
        return view('pages.hr.tasks.mappings.unit', compact('unit','mappings' ));
    }
}
