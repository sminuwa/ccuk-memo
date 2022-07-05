<?php

namespace App\Http\Controllers;

use App\Models\AccountInvoice;
use App\Models\Branch;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function index(){
        $invoices = AccountInvoice::orderBy('id', 'desc')->get();
        return view('pages.accounting.invoices.index', compact('invoices'));
    }

    public function create(Request $request) {
        $Model = "\App\Models\\".$request->model;
        $model = $Model::find($request->model_id);
        $reference = "REF/100/REF";
        $account = "";
        $payee = "";
        $description = "";
        $site = Branch::where('name','like','%Transport%')->first();
        return view('pages.accounting.invoices.create', compact('description','reference', 'account', 'payee','model','site'));
    }

    public function store(Request $request){
        return $request;
    }
}
