<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PermissionUser;
use App\Models\User;
use App\Models\Permission;


/**
 * Description of PermissionUserController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class PermissionUserController extends Controller
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
        return view('pages.permission_users.index', ['records' => PermissionUser::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  PermissionUser  $permissionuser
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PermissionUser $permissionuser)
    {
        return view('pages.permission_users.show', [
                'record' =>$permissionuser,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$users = User::all(['id']);
		$permissions = Permission::all(['id']);

        return view('pages.permission_users.create', [
            'model' => new PermissionUser,
			"users" => $users,
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
        $model=new PermissionUser;
        $model->id = newId();
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'PermissionUser saved successfully');
            return redirect()->route('permission_users.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving PermissionUser');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  PermissionUser  $permissionuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PermissionUser $permissionuser)
    {
		$users = User::all(['id']);
		$permissions = Permission::all(['id']);

        return view('pages.permission_users.edit', [
            'model' => $permissionuser,
			"users" => $users,
			"permissions" => $permissions,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  PermissionUser  $permissionuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,PermissionUser $permissionuser)
    {
        $permissionuser->fill($request->all());

        if ($permissionuser->save()) {

            session()->flash('app_message', 'PermissionUser successfully updated');
            return redirect()->route('permission_users.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating PermissionUser');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  PermissionUser  $permissionuser
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, PermissionUser $permissionuser)
    {
        if ($permissionuser->delete()) {
                session()->flash('app_message', 'PermissionUser successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting PermissionUser');
            }

        return redirect()->back();
    }
}
