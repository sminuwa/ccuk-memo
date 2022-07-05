<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\PayrollItem;
use App\Models\PayrollPayslip;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollReportController extends Controller
{
    public function itemsSummary(Request $request){
        $method = $request->method();
        $months = $months = $this->months();
        if($method == 'GET'){
            $salaryItems = PayrollItem::itemReports()->get();
            return view('pages.payroll.report.items-summary', compact('salaryItems', 'months'));
        }
        if($method == 'POST'){
            $month = $request->month;
            $year = date('Y', strtotime($month));
            $allowances = PayrollPayslip::itemSummary($year)->month($month)->typeNot('Deduction')->get();
            $deductions = PayrollPayslip::itemSummary($year)->month($month)->type('Deduction')->get();
            $pensions = PayrollPayslip::itemSummary($year)->month($month)->confirmedStaff()->joinStaff()->category('Regular')->typeNot('Deduction')->get();
            return view('pages.payroll.report.ajax.items-summary', compact('pensions','allowances', 'deductions', 'month'));
        }
    }

    public function staffPerItem(Request $request){
        $method = $request->method();
        $months = $months = $this->months();
        if($method == "GET"){
            return view('pages.payroll.report.staff-per-item', compact('months'));
        }
        if($method == "POST") {
            $item = $request->item;
            $month = $request->month;
            $branch_id = $request->branch_id;
            if($branch_id == '*')
                $branches = Branch::all('id')->pluck('id')->toArray();
            if($branch_id != '*')
                $branches = [$branch_id];
            $reports = PayrollPayslip::item($item)->month($month)->itemReport()->branch($branches)->orderBy('branch_name','asc')->get();
//            return $reports;
            $items = PayrollItem::where('name', $item)->first();
            return view('pages.payroll.report.ajax.staff-per-item', compact('reports',  'items','month'));
        }
    }

    public function itemsPerStaff(Request $request){
        $method = $request->method();
        $months = $this->months();
        if($method == "GET"){
            return view('pages.payroll.report.items-per-staff', compact('months'));
        }
        if($method == "POST"){
            $staff_id = $request->staff_id;
            $month = $request->month;
            $reports = PayrollPayslip::staff($staff_id)->month($month)->staffReport()->get();
            $user = User::find($staff_id);
            return view('pages.payroll.report.ajax.items-per-staff', compact('reports', 'user', 'month'));
        }
    }

    public function months(){
        return PayrollPayslip::distinct()->selectRaw("DATE_FORMAT(date,'%M, %Y') as month_title, DATE_FORMAT(date,'%Y-%m') as month_value, date")->orderBy('date', 'desc')->get();
    }
}
