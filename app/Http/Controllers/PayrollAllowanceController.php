<?php

namespace App\Http\Controllers;

use App\Models\PayrollAllowance;
use App\Models\PayrollDeduction;
use App\Models\PayrollUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollAllowanceController extends Controller
{
    //
    public function index(){
//        return DB::select(DB::raw("select * from users"));
        $users = User::selectRaw("users.*, pu.confirmation, pu.status, pa.id AS payroll_allowance_id, pu.id AS payroll_user_id, pi.name, pi.id as item_id, pa.amount, pa.start_date, pa.installment,pa.description, (SELECT count(id) FROM payroll_payslips WHERE item = pi.name AND payroll_user_id = pu.id  ) as deducted")
            ->join('payroll_users as pu', 'users.id', '=', 'pu.user_id')
            ->join('payroll_allowances as pa', 'pa.payroll_user_id','=', 'pu.id')
            ->join('payroll_items as pi', 'pi.id', '=', 'pa.item_id')
//            ->where('pu.status', User::STATUS_ACTIVE)
            ->orderBy('pa.id', 'desc')->get();
        return view('pages.payroll.allowances.index', compact('users'));
    }

    public function store(Request $request){
        try{
            $payroll_allowance_id = $request->payroll_allowance_id;
            $allowance = PayrollAllowance::find($payroll_allowance_id);
            if(!$allowance){
                $allowance = new PayrollAllowance();
                $payroll_user = PayrollUser::where('user_id',$request->user_id)->first();
                if(!$payroll_user)
                    return back()->with('error', 'User has not been enrolled in the payroll');
                $allowance->payroll_user_id = $payroll_user->id;
            }
            $allowance->item_id = $request->item_id;
            $allowance->start_date = $request->start_date;
            $allowance->installment = $request->installment;
            $allowance->amount = $request->amount;
            $allowance->description = $request->description;
            $allowance->save();
            return back()->with('success', 'Done successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(PayrollAllowance $allowance){
        try{
            $allowance->delete();
            return back()->with('success', 'Deduction removed successfully');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }
}
