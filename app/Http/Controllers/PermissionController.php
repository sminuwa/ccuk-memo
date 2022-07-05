<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;


/**
 * Description of PermissionController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth","permission"]);
    }
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.permissions.index', ['records' => Permission::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Permission $permission)
    {
        return view('pages.permissions.show', [
                'record' =>$permission,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.permissions.create', [
            'model' => new Permission,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new Permission;
        $model->id = newId();
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Permission saved successfully');
            return redirect()->route('permissions.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Permission');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Permission $permission)
    {

        return view('pages.permissions.edit', [
            'model' => $permission,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Permission $permission)
    {
        $permission->fill($request->all());

        if ($permission->save()) {

            session()->flash('app_message', 'Permission successfully updated');
            return redirect()->route('permissions.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Permission');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Permission $permission)
    {
        if ($permission->delete()) {
                session()->flash('app_message', 'Permission successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Permission');
            }

        return redirect()->back();
    }
}
