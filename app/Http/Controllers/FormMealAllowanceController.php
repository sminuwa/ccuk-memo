<?php

namespace App\Http\Controllers;

use App\Models\FormMealAllowanceDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormMealAllowance;


/**
 * Description of FormMealAllowanceController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class FormMealAllowanceController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mealAllowances = FormMealAllowance::latest()->get();
        return view('forms.meal-allowances.index', compact('mealAllowances'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param FormMealAllowance $mealAllowance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FormMealAllowance $mealAllowance)
    {

        return view('forms.meal-allowances.show', compact('mealAllowance'));
    }   /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $user = auth()->id();
            $name = $request->name;
            $date = $request->date;
            $no_of_days = $request->no_of_days;
            $amount = $request->amount;
            $meal = new FormMealAllowance();
            $meal->prepared_by = $user;
            if($meal->save()){
                for($i = 0; $i < count($name); $i++){
                    $detail = FormMealAllowanceDetail::where(['form_meal_allowance_id'=>$meal->id, 'user_id'=>$user])->first();
                    if(!$detail)
                        $detail = new FormMealAllowanceDetail();
                    $detail->form_meal_allowance_id = $meal->id;
                    $detail->user_id = $name[$i];
                    $detail->date = $date[$i];
                    $detail->no_of_days = $no_of_days[$i];
                    $detail->amount = $amount[$i];
                    $detail->save();
                }
                return back()->with('message','Meal Allowance Form created successfully');
            }
        }catch (\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  FormMealAllowance  $formmealallowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FormMealAllowance $formmealallowance)
    {

        return view('pages.form_meal_allowances.edit', [
            'model' => $formmealallowance,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  FormMealAllowance  $formmealallowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,FormMealAllowance $formmealallowance)
    {
        $formmealallowance->fill($request->all());

        if ($formmealallowance->save()) {
            
            session()->flash('app_message', 'FormMealAllowance successfully updated');
            return redirect()->route('form_meal_allowances.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating FormMealAllowance');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  FormMealAllowance  $formmealallowance
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, FormMealAllowance $mealAllowance)
    {
        if ($mealAllowance->delete()) {
                session()->flash('message', 'successfully deleted');
            } else {
                session()->flash('error', 'Error occurred while deleting FormMealAllowance');
            }

        return redirect()->back();
    }
}
