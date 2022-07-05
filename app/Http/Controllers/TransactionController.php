<?php

namespace App\Http\Controllers;

use App\Models\AccountNumber;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function index(){

    }

    public function openingBalance(Request $request){
        try{
            $transaction = new Transaction();
            $transaction->reference = "001";
            $transaction->model_id = $request->model_id;
            $transaction->model_name = $request->model_name;
            $transaction->account = $request->account_number;
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->description = $request->description;
            $transaction->code = $request->code;
            $transaction->date = $request->date;
            $transaction->user_id = auth()->id();
            $transaction->save();
            return back()->with('success', 'Opening balance has been updated');
        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        try{
            $account = AccountNumber::where(['model_id'=>$request->model_id, 'model_name'=>$request->model_name])->first();
            if(!$account)
                return back()->with('error', 'Invalid model');
            $model_id = $account->id;
            $model_name = class_basename($account);
            $number = $account->number;
            $transaction = new Transaction();
            $transaction->reference_id = $request->model_id;
            $transaction->reference_model = $request->model_name;
            $transaction->model_id = $model_id;
            $transaction->model_name = $model_name;
            $transaction->account = $number;
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->description = $request->description;
            $transaction->code = $request->code;
            $transaction->date = $request->date;
            $transaction->user_id = auth()->id();
            $transaction->save();
            return back()->with('success', 'Opening balance has been updated');
        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
