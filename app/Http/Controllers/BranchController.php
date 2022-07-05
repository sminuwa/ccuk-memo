<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;


/**
 * Description of BranchController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth"]);
        $this->middleware('permission:branch.index');

    }
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.branches.index', ['records' => Branch::orderBy('name', 'asc')->get()]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Branch $branch)
    {
        return view('pages.branches.show', [
                'record' =>$branch,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.branches.create', [
            'model' => new Branch,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model =Branch::find($request->p_id);
        if(!$model)
            $model=new Branch;
        $model->name = $request->name;
        $model->code = $request->code;
        if ($model->save()) {
            //activity()->on($model)->log('Created / Edited Branch');
            session()->flash('app_message', 'Branch saved successfully');
            return redirect()->route('branch.index');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Branch');
        }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Branch $branch)
    {

        return view('pages.branches.edit', [
            'model' => $branch,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Branch $branch)
    {
        $branch->fill($request->all());

        if ($branch->save()) {

            session()->flash('app_message', 'Branch successfully updated');
            return redirect()->route('branches.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Branch');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  Branch  $branch
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request,$id)
    {
        $branch =Branch::find($id);
        if ($branch->delete()) {
                session()->flash('app_message', 'Branch successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Branch');
            }

        return redirect()->back();
    }


    public function departments(Request $request)
    {
        $id = $request->branch_id;
        return Department::where(['branch_id'=>$id])->orderBy('name','ASC')->get();
    }
}
