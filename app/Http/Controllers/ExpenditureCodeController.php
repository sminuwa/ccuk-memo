<?php

namespace App\Http\Controllers;

use App\Models\AccountCode;
use App\Models\BankSupplier;
use App\Models\CashBook;
use App\Models\StaffCode;
use Illuminate\Http\Request;

class ExpenditureCodeController extends Controller
{
    //
    public function index(){

    }

    public function store(){

    }

    public function select2Ajax(Request $request){

//        return $request;
        $s = $request->search;
//        return $s;
        $accountCodes = AccountCode::whereRaw("code like '%$s%' OR description like '%$s%' ")->get();
        $bankSuppliers = BankSupplier::whereRaw("code like '%$s%' OR description like '%$s%' ")->get();
        $cashBooks = CashBook::whereRaw("name like '%$s%' OR code like '%$s%' OR description like '%$s%' ")->get();
        $staffCodes = StaffCode::whereRaw("code like '%$s%' OR description like '%$s%' ")->get();

        $codes = $account = $bank = $cash = $staff = [];
        foreach ($accountCodes as $accountCode){
            $account[] = [
                    "text"=>$accountCode->code.' - '.$accountCode->description,
                    "id"=>$accountCode->code ];
        }
        foreach ($bankSuppliers as $bankSupplier){
            $bank[] = [
                "text"=>$bankSupplier->code.' - '.$bankSupplier->description,
                "id"=>$bankSupplier->code ];
        }
        foreach ($cashBooks as $cashBook){
            $cash[] = [
                "text"=>$cashBook->code.' - '.$cashBook->name.' - '.$cashBook->description,
                "id"=>$cashBook->code ];
        }
        foreach ($staffCodes as $staffCode){
            $staff[] = [
                "text"=>$staffCode->code.' - '.$staffCode->description,
                "id"=>$staffCode->code ];
        }

        $codes[] = [
            "text" => "Account Codes",
            "children" => $account];
        $codes[] = [
            "text" => "Bank Suppliers",
            "children" => $bank];
        $codes[] = [
            "text" => "Cash Books",
            "children" => $cash ];
        $codes[] = [
            "text" => "Staff Codes",
            "children" => $staff ];



        return $codes;
    }
}
