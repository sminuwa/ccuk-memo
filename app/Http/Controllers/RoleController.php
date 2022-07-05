<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;


/**
 * Description of RoleController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class RoleController extends Controller
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
        return view('pages.roles.index', ['records' => Role::orderBy('name','asc')->get()]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {
        return view('pages.roles.show', [
                'record' =>$role,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.roles.create', [
            'model' => new Role,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new Role;
        if($request->p_id)
            $model =Role::find($request->p_id);
        $model->id = newId();
        $model->fill($request->only('name'));

        if ($model->save()) {
            //activity()->on($model)->log('Role created / edited');
            session()->flash('app_message', 'Role saved successfully');
            return redirect()->route('role.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Role');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {

        return view('pages.roles.edit', [
            'model' => $role,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        $role->fill($request->all());

        if ($role->save()) {

            session()->flash('app_message', 'Role successfully updated');
            return redirect()->route('roles.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Role');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $role = Role::find($id);
        if ($role->delete()) {
                session()->flash('app_message', 'Role successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Role');
            }

        return redirect()->back();
    }

    public function permissions(Request $request,$id)
    {
        $permissions = Permission::selectRaw("*,(SELECT COUNT(permission_roles.id) FROM permission_roles WHERE permission_roles.role_id=1 AND permission_id=permissions.id) AS has")->get();

        return view("pages.roles.permissions",compact('permissions'));
    }


    public function permissionsAssign(Request $request)
    {
        if($request->p_id){
            $arr =[];
            PermissionRole::where(["role_id"=>$request->p_id])->delete();
            foreach ($request->permissions as $p){
                $arr[] = ["role_id"=>$request->p_id,"permission_id"=>$p];
            }
        }

        PermissionRole::insert($arr);
        return back();
    }

    public function assign(Request $request,$action,$role_id,$user_id)
    {
        //return $request;
        $r = RoleUser::where(["user_id"=>$user_id,"role_id"=>$role_id])->first();

        if(!$r){
          if($action=="assign"){
              $r = new RoleUser();
              $r->id = newId();
              $r->role_id = $role_id;
              $r->user_id = $user_id;
              $r->save();
          }
        }else{
            if($action=="revoke"){
                $r->delete();
            }
        }
        return back();
    }


    public function lister(Request $request, $user_id)
    {
        $roles = Role::all();
        $user = User::find($user_id);
        return view("pages.roles.list", compact('user','roles'));
    }
}
