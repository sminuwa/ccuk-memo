<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\PayrollPayslip;
use App\Models\PayrollUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    //
    public function salarySheet(Request $request){
//        return User::find(1000010)->totalAllowances('Other');
        $staffs = User::select('users.*')
            ->join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
            ->where('payroll_users.status', 'Active')->orderBy('users.id', 'asc')->get();
        $branches = Branch::orderBy('name', 'asc')->get();
        $salarySheet = [];

        
        $type = "Regular";
        if($request->type)
            $type = $request->type;
        return view('pages.payroll.salary-sheet.index', compact('staffs', 'branches', 'type'));
    }

    public function branchSalarySheet(Request $request){
        $branch_id = $request->branch;
        $month = $request->month;
        $type = "Regular";
        if($request->type)
            $type = $request->type;
        $branch = Branch::find($branch_id);
        $staffs = User::select('users.*')
            ->join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
            ->join('user_details', 'user_details.user_id', '=', 'users.id')
            ->where('payroll_users.status', 'Active')
            ->where('user_details.branch_id',$branch_id)
            ->orderBy('users.id', 'asc')->get();
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('pages.payroll.salary-sheet.index', compact('staffs', 'type','branches', 'branch','month'));
    }

    public function deductions(){
        $users = User::select('users.*', 'pu.confirmation', 'pu.status', 'pu.id as payroll_user_id', 'pu.account_number', 'b.id as bank', 'pu.level', 'pu.step')
            ->where('users.status', User::STATUS_ACTIVE)
            ->join('payroll_users as pu', 'users.id', '=', 'pu.user_id')
            ->leftJoin('banks as b', 'b.id', '=', 'pu.bank_id')
            ->orderBy('pu.id', 'desc')->get();
        return view('pages.payroll.deductions.index', compact('users'));
    }
    public function allowances(){
        $users = User::select('users.*', 'pu.confirmation', 'pu.status', 'pu.id as payroll_user_id', 'pu.account_number', 'b.id as bank', 'pu.level', 'pu.step')
            ->where('users.status', User::STATUS_ACTIVE)
            ->join('payroll_users as pu', 'users.id', '=', 'pu.user_id')
            ->leftJoin('banks as b', 'b.id', '=', 'pu.bank_id')
            ->orderBy('pu.id', 'desc')->get();
        return view('pages.payroll.deductions.index', compact('users'));
    }

    public function payrollIndex(){
        $users = User::select('users.*', 'pu.confirmation', 'pu.status', 'pu.id as payroll_user_id', 'pu.account_number', 'b.id as bank', 'pu.level', 'pu.step')
            ->join('payroll_users as pu', 'users.id', '=', 'pu.user_id')
//            ->where('pu.status', PayrollUser::STATUS_ACTIVE)
            ->leftJoin('banks as b', 'b.id', '=', 'pu.bank_id')
            ->orderBy('pu.id', 'desc')->get();
        $banks = Bank::orderBy('name', 'asc')->get();
        return view('pages.payroll.staff.index', compact('users','banks'));
    }

    public function showStaff(User $user){
        $months = PayrollPayslip::select(DB::raw("MONTHNAME(date) as month"))->distinct()->orderBy('date', 'desc')->pluck('month');
        $users = User::select('users.*')
            ->join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
//            ->where('payroll_users.status', PayrollUser::STATUS_ACTIVE)
            ->orderBy('users.id', 'asc')->get();
        /*return $months;*/
        return view('pages.payroll.staff.show', compact('user'));
    }

    public function addPayroll(Request $request){
        try{

            $staff = PayrollUser::find($request->payroll_user_id);
            if(!$staff)
                $staff = new PayrollUser();
            if(!$request->payroll_user_id)
                $staff->user_id = $request->user_id;
            $staff->level = $request->level;
            $staff->step = $request->step;
            $staff->confirmation = $request->confirmation;
            $staff->status = $request->status;
            $staff->account_number = $request->account;
            $staff->bank_id = $request->bank;
            $staff->save();

            return back()->with('success', 'Done successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(PayrollUser $staff){
        try{
            $staff->delete();
            return back()->with('success','Record deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
   /* public function showPayslip(User $user){
        return view('pages.payroll.staff.payslip', compact('user'));
    }*/
    public function makePayment(){
        $branches = Branch::orderBy('name', 'asc')->get();
        try{
            foreach($branches as $branch){
                foreach($branch->salaryStaff() as $staff){
                    foreach($staff->basic() as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Basic', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m').'%')
                            ->first();
                        if(!$payslip)
                            $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Basic';
                        $payslip->amount = ($salary->amount / 12);
                        $payslip->date = date('Y-m-d');
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->allowances() as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Allowance', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m').'%')
                            ->first();
                        if(!$payslip)
                            $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Allowance';
                        $payslip->amount = ($salary->amount / 12);
                        $payslip->date = date('Y-m-d');
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->deductions() as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Deduction', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m').'%')
                            ->first();
                        if(!$payslip)
                            $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Deduction';
                        $payslip->amount = ($salary->amount / 12);
                        $payslip->date = date('Y-m-d');
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->otherDeductions() as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Deduction', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m').'%')
                            ->first();
                        if(!$payslip)
                            $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Deduction';
                        $payslip->amount = $salary->amount;
                        $payslip->date = date('Y-m-d');
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->otherAllowances() as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Allowance', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m').'%')
                            ->first();
                        if(!$payslip)
                            $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Allowance';
                        $payslip->amount = $salary->amount;
                        $payslip->date = date('Y-m-d');
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                }
            }
            return back()->with('success','Payment has been successfully');
        }catch (\Exception $e){
            return back()->with('error','Something went wrong');
        }

    }

    public function bankSheet(Request $request){
//        return User::find(1000010)->totalAllowances('Other');
        $staffs = User::select('users.*')
            ->join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
            ->where('payroll_users.status', 'Active')->orderBy('users.id', 'asc')->get();
        $banks = Bank::orderBy('name', 'asc')->get();
        $type = "Regular";
        if($request->type)
            $type = $request->type;
        return view('pages.payroll.salary-sheet.bank', compact('staffs', 'banks', 'type'));
    }

    public function bankSalarySheet(Request $request){
        $bank_id = $request->bank;
        $month = $request->month;
        $type = "Regular";
        if($request->type)
            $type = $request->type;
        $bank = Bank::find($bank_id);
        $staffs = User::select('users.*','b.name as bank', 'pu.account_number')
                ->join('payroll_users as pu', 'users.id', '=', 'pu.user_id')
                ->join('user_details as ud', 'ud.user_id', '=', 'users.id')
                ->join('banks as b', 'b.id', '=', 'pu.bank_id')
                ->where(['pu.status'=>'Active','bank_id'=>$bank_id])
                ->orderBy('users.id', 'asc')->get();
        $banks = Bank::orderBy('name', 'asc')->get();
        return view('pages.payroll.salary-sheet.bank', compact('staffs', 'type','banks', 'bank','month'));
    }


}
