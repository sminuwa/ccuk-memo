<?php

namespace App\Http\Controllers;

use App\Models\PayrollDeduction;
use App\Models\PayrollUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollDeductionController extends Controller
{
    public function index(){
        $users = User::selectRaw("users.*, pu.confirmation, pu.status, pd.id AS payroll_deduction_id, pu.id AS payroll_user_id, pi.name, pi.id as item_id, pd.amount, pd.start_date, pd.installment,pd.description, (SELECT count(id) FROM payroll_payslips WHERE item = pi.name AND payroll_user_id = pu.id) as deducted")
            ->where('users.status', User::STATUS_ACTIVE)
            ->join('payroll_users as pu', 'users.id', '=', 'pu.user_id')
            ->join('payroll_deductions as pd', 'pd.payroll_user_id','=', 'pu.id')
            ->join('payroll_items as pi', 'pi.id', '=', 'pd.item_id')
            ->orderBy('pd.id', 'desc')->get();
        return view('pages.payroll.deductions.index', compact('users'));
    }

    public function store(Request $request){
        try{
            $payroll_deduction_id = $request->payroll_deduction_id;
            $deduction = PayrollDeduction::find($payroll_deduction_id);
            if(!$deduction){
                $deduction = new PayrollDeduction();
                $payroll_user = PayrollUser::where('user_id',$request->user_id)->first();
                if(!$payroll_user)
                    return back()->with('error', 'User has not been enrolled in the payroll');
                $deduction->payroll_user_id = $payroll_user->id;
            }
            $deduction->item_id = $request->item_id;
            $deduction->start_date = $request->start_date;
            $deduction->installment = $request->installment;
            $deduction->amount = $request->amount;
            $deduction->description = $request->description;
            $deduction->save();
            return back()->with('success', 'Done successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(PayrollDeduction $deduction){
        try{
            $deduction->delete();
            return back()->with('success', 'Deduction removed successfully');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }
}
