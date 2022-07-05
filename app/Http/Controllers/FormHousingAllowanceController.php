<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormHousingAllowance;


/**
 * Description of FormHousingAllowanceController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class FormHousingAllowanceController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $housingAllowances = FormHousingAllowance::latest()->get();
        return view('forms.housing-allowances.index', compact('housingAllowances'));
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  FormHousingAllowance  $formhousingallowance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FormHousingAllowance $housingAllowance)
    {
        return view('pages.form_housing_allowances.show', compact('housingAllowance'));

    }      /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new FormHousingAllowance;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'FormHousingAllowance saved successfully');
            return redirect()->route('form_housing_allowances.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving FormHousingAllowance');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  FormHousingAllowance  $formhousingallowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FormHousingAllowance $formhousingallowance)
    {

        return view('pages.form_housing_allowances.edit', [
            'model' => $formhousingallowance,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  FormHousingAllowance  $formhousingallowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,FormHousingAllowance $formhousingallowance)
    {
        $formhousingallowance->fill($request->all());

        if ($formhousingallowance->save()) {
            
            session()->flash('app_message', 'FormHousingAllowance successfully updated');
            return redirect()->route('form_housing_allowances.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating FormHousingAllowance');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  FormHousingAllowance  $formhousingallowance
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, FormHousingAllowance $formhousingallowance)
    {
        if ($formhousingallowance->delete()) {
                session()->flash('app_message', 'FormHousingAllowance successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting FormHousingAllowance');
            }

        return redirect()->back();
    }
}
