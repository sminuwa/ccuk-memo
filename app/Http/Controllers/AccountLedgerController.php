<?php

namespace App\Http\Controllers;

use App\Models\AccountLedger;
use Illuminate\Http\Request;

class AccountLedgerController extends Controller
{
    public function searchGl(Request $request){
        $q = $request->search;
        $accountLedgers = AccountLedger::whereRaw("(code LIKE '%$q%' OR description like '%$q%')")->get();
        $bank = [];
        foreach ($accountLedgers as $accountLedger){
            $bank[] = ["text" => $accountLedger->code . ' - ' . $accountLedger->description, "id" => $accountLedger->code];
        }
        return $bank;
    }
}
