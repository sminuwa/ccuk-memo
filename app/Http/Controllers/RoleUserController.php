<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Role;


/**
 * Description of RoleUserController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class RoleUserController extends Controller
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
        return view('pages.role_users.index', ['records' => RoleUser::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  RoleUser  $roleuser
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RoleUser $roleuser)
    {
        return view('pages.role_users.show', [
                'record' =>$roleuser,
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
		$roles = Role::all(['id']);

        return view('pages.role_users.create', [
            'model' => new RoleUser,
			"users" => $users,
			"roles" => $roles,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	return $request;
        $model=new RoleUser;
        $model->id = newId();
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'RoleUser saved successfully');
            return redirect()->route('role_users.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving RoleUser');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  RoleUser  $roleuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RoleUser $roleuser)
    {
		$users = User::all(['id']);
		$roles = Role::all(['id']);

        return view('pages.role_users.edit', [
            'model' => $roleuser,
			"users" => $users,
			"roles" => $roles,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  RoleUser  $roleuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,RoleUser $roleuser)
    {
        $roleuser->fill($request->all());

        if ($roleuser->save()) {

            session()->flash('app_message', 'RoleUser successfully updated');
            return redirect()->route('role_users.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating RoleUser');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  RoleUser  $roleuser
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, RoleUser $roleuser)
    {
        if ($roleuser->delete()) {
                session()->flash('app_message', 'RoleUser successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting RoleUser');
            }

        return redirect()->back();
    }
}
