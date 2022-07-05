<?php

namespace App\Http\Controllers;

use App\Models\PayrollSalaryStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollSalaryStructureController extends Controller
{
    //
    public function index(){
        $structures = [];
        $levels = DB::table('payroll_salary_structures')->select('id','level')->groupBy('level')->get();
        foreach($levels as $level){
            $lvl = $level->level;
            $steps = [];
            $levelStep = DB::table('payroll_salary_structures')->select('id','step')->groupBy('step')->where('level',$lvl)->get();
            foreach($levelStep as $step){
                $stp = $step->step;
                $steps[] = [
                    'step'=>$stp,
                    'items'=>DB::table('payroll_salary_structures')->select('payroll_salary_structures.*', 'payroll_items.name')->where(['level'=> $lvl, 'step'=>$stp])->join('payroll_items','payroll_items.id', 'payroll_salary_structures.item_id')->get()
                ];
            }

            $structures[] = [
                "level"=>$lvl,
                'structure'=>json_decode(json_encode($steps))
            ];
        }
        $structures = json_decode(json_encode($structures));
//        return $structures;
        return view('pages.payroll.salary-structure.index', compact('structures'));
    }

    public function store(Request $request){
        try{
            $item_id = $request->item_id;
            $item = PayrollSalaryStructure::find($item_id);
            if(!$item)
                $item = new PayrollSalaryStructure();
            $item->item_id = $request->_item_id;
            $item->type = $request->type;
            $item->level = $request->level;
            $item->step = $request->step;
            $item->amount = str_replace(',','',$request->amount);
            $item->save();
            return back()->with('success', 'Done successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function levelSteps($level){

    }

    public function stepStructures($level, $step){

    }

    public function destroy(PayrollSalaryStructure $structure){
        try{
            $structure->delete();
            return back()->with('success', 'Record deleted successfully');
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong');
        }

    }
}
