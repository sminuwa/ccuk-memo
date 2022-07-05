<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\PayrollPayslip;
use Illuminate\Http\Request;

class PayrollPaymentController extends Controller
{
    //
    public function index(){
        return view('pages.payroll.payments.index');
    }

    public function makePayment(Request $request){
        $month = $request->month;
        $type = $request->type;
        $branches = Branch::orderBy('name', 'asc')->get();
        try{
            foreach($branches as $branch){
                foreach($branch->salaryStaff() as $staff){
                    foreach($staff->basic($type) as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Basic', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m', strtotime($month)).'%')
                            ->first();
                        if(!$payslip)
                        $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Basic';
                        $payslip->amount = ($salary->amount / 12);
                        $payslip->date = date('Y-m-d',strtotime($month));
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->allowances($type) as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Allowance', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m',strtotime($month)).'%')
                            ->first();
                        if(!$payslip)
                        $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Allowance';
                        $payslip->amount = ($salary->amount / 12);
                        $payslip->date = date('Y-m-d', strtotime($month));
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->deductions($type) as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Deduction', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m', strtotime($month)).'%')
                            ->first();
                        if(!$payslip)
                        $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Deduction';
                        $payslip->amount = ($salary->amount / 12);
                        $payslip->date = date('Y-m-d', strtotime($month));
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->otherDeductions($type) as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Deduction', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m',strtotime($month)).'%')
                            ->first();
                        if(!$payslip)
                        $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Deduction';
                        $payslip->amount = $salary->amount;
                        $payslip->date = date('Y-m-d', strtotime($month));
                        $payslip->payroll_user_id = $staff->payroll_user_id;
                        $payslip->level = $salary->level;
                        $payslip->step = $salary->step;
                        $payslip->category = $salary->item->type;
                        $payslip->save();
                    }
                    foreach($staff->otherAllowances($type) as $salary){
                        $payslip = PayrollPayslip::where(['item'=>$salary->item->name,'type'=>'Allowance', 'payroll_user_id'=>$staff->payroll_user_id, 'level'=>$salary->level,'step'=>$salary->step])
                            ->where('date','like','%'.date('Y-m',strtotime($month)).'%')
                            ->first();
                        if(!$payslip)
                        $payslip = new PayrollPayslip();
                        $payslip->item = $salary->item->name;
                        $payslip->type = 'Allowance';
                        $payslip->amount = $salary->amount;
                        $payslip->date = date('Y-m-d', strtotime($month));
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
            return back()->with('error',$e->getMessage());
        }

    }
}
