<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormMealAllowanceDetail;


/**
 * Description of FormMealAllowanceDetailController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class FormMealAllowanceDetailController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.form_meal_allowance_details.index', ['records' => FormMealAllowanceDetail::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  FormMealAllowanceDetail  $formmealallowancedetail
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FormMealAllowanceDetail $formmealallowancedetail)
    {
        return view('pages.form_meal_allowance_details.show', [
                'record' =>$formmealallowancedetail,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.form_meal_allowance_details.create', [
            'model' => new FormMealAllowanceDetail,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new FormMealAllowanceDetail;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'FormMealAllowanceDetail saved successfully');
            return redirect()->route('form_meal_allowance_details.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving FormMealAllowanceDetail');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  FormMealAllowanceDetail  $formmealallowancedetail
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FormMealAllowanceDetail $formmealallowancedetail)
    {

        return view('pages.form_meal_allowance_details.edit', [
            'model' => $formmealallowancedetail,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  FormMealAllowanceDetail  $formmealallowancedetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,FormMealAllowanceDetail $formmealallowancedetail)
    {
        $formmealallowancedetail->fill($request->all());

        if ($formmealallowancedetail->save()) {
            
            session()->flash('app_message', 'FormMealAllowanceDetail successfully updated');
            return redirect()->route('form_meal_allowance_details.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating FormMealAllowanceDetail');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  FormMealAllowanceDetail  $formmealallowancedetail
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, FormMealAllowanceDetail $formmealallowancedetail)
    {
        if ($formmealallowancedetail->delete()) {
                session()->flash('app_message', 'FormMealAllowanceDetail successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting FormMealAllowanceDetail');
            }

        return redirect()->back();
    }
}
