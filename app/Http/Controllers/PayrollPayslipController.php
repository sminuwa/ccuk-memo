<?php

namespace App\Http\Controllers;

use App\Models\PayrollPayslip;
use App\Models\PayrollUser;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollPayslipController extends Controller
{
    //

    public function myPayrollShow(){
        return view('pages.payroll.my-payslip.index');
    }

    public function showPayslip($month, $u){
        $payroll_user = PayrollUser::where('user_id', $u)->first();
        $user = User::find($payroll_user->user_id);
//        return PayrollPayslip::where('date','like', '%2022-03%')->where('payroll_user_id',4)->get();
        return view('pages.payroll.staff.payslip', compact('month','user'));
        return $user->payslip($month);
    }
}
