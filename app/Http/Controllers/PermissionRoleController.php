<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\Permission;


/**
 * Description of PermissionRoleController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class PermissionRoleController extends Controller
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
        return view('pages.permission_roles.index', ['records' => PermissionRole::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  PermissionRole  $permissionrole
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PermissionRole $permissionrole)
    {
        return view('pages.permission_roles.show', [
                'record' =>$permissionrole,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$roles = Role::all(['id']);
		$permissions = Permission::all(['id']);

        return view('pages.permission_roles.create', [
            'model' => new PermissionRole,
			"roles" => $roles,
			"permissions" => $permissions,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new PermissionRole;
        $model->id = newId();
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'PermissionRole saved successfully');
            return redirect()->route('permission_roles.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving PermissionRole');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  PermissionRole  $permissionrole
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PermissionRole $permissionrole)
    {
		$roles = Role::all(['id']);
		$permissions = Permission::all(['id']);

        return view('pages.permission_roles.edit', [
            'model' => $permissionrole,
			"roles" => $roles,
			"permissions" => $permissions,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  PermissionRole  $permissionrole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,PermissionRole $permissionrole)
    {
        $permissionrole->fill($request->all());

        if ($permissionrole->save()) {

            session()->flash('app_message', 'PermissionRole successfully updated');
            return redirect()->route('permission_roles.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating PermissionRole');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  PermissionRole  $permissionrole
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, PermissionRole $permissionrole)
    {
        if ($permissionrole->delete()) {
                session()->flash('app_message', 'PermissionRole successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting PermissionRole');
            }

        return redirect()->back();
    }
}
