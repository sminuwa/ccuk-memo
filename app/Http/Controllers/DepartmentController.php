<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Branch;


/**
 * Description of DepartmentController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth"]);
        $this->middleware('permission:department.index');
    }
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.departments.index', ['records' => Department::orderBy('name','asc')->get()]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Department $department)
    {
        return view('pages.departments.show', [
                'record' =>$department,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$branches = Branch::all(['id']);

        return view('pages.departments.create', [
            'model' => new Department,
			"branches" => $branches,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Department::find($request->p_id);
        if(!$model)
            $model=new Department;
        $model->branch_id = $request->branch_id;
        $model->name = $request->name;
        $model->code = $request->code;
        if ($model->save()) {

            session()->flash('app_message', 'Department saved successfully');
            return redirect()->route('department.index');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Department');
        }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Department $department)
    {
		$branches = Branch::all(['id']);

        return view('pages.departments.edit', [
            'model' => $department,
			"branches" => $branches,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Department $department)
    {
        $department->fill($request->all());

        if ($department->save()) {

            session()->flash('app_message', 'Department successfully updated');
            return redirect()->route('departments.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Department');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  Department  $department
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {

        $department = Department::find($id);
        if ($department->delete()) {
                session()->flash('app_message', 'Department successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Department');
            }

        return redirect()->back();
    }
}
