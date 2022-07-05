<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    //

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
        return view('pages.groups.index', ['records' => Group::orderBy('name', 'asc')->get()]);
    }    /**
 * Display the specified resource.
 *
 * @param  Request  $request
 * @param  Branch  $branch
 * @return \Illuminate\Http\Response
 */
    public function show(Request $request, $id)
    {

        $group = Group::find($id);
        $staff = User::whereIn('id',$group->members()->pluck('user_id'))->get();
        return view('pages.groups.show', [
            'record' =>$group,"staff"=>$staff
        ]);

    }    /**
 * Show the form for creating a new resource.
 *
 * @param  Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create(Request $request)
    {

        return view('pages.groups.create', [
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
        $model=new Group;
        $model->id = newId();
        if($request->p_id)
            $model =Group::find($request->p_id);
        $model->fill(["name"=>$request->input('name')]);

        if ($model->save()) {
            //activity()->on($model)->log('Created / edited group');
            session()->flash('app_message', 'Group saved successfully');
            return redirect()->route('group.index');
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
 * @param  Group  $branch
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
 * @param  Group  $branch
 * @return \Illuminate\Http\Response
 * @throws \Exception
 */
    public function destroy(Request $request,$id)
    {
        $branch = Group::find($id);
        if ($branch->delete()) {
            session()->flash('app_message', 'Group successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Group');
        }

        return redirect()->back();
    }
    public function userDestroy(Request $request,$user_id,$group_id)
    {
        $branch = GroupMember::where(["user_id"=>$user_id,"group_id"=>$group_id]);
        if ($branch->delete()) {
            session()->flash('app_message', 'Group successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Group');
        }

        return redirect()->back();
    }

    public function addUser(Request $request)
    {

//        $gr = GroupMember::whereNotIn()->pluck();
        if(!empty($request->users)) {
            foreach ($request->users as $user) {
                $gr = GroupMember::where(["user_id" => $user, "group_id" => $request->group_id])->first();
                if (!$gr) {
                    $gr = new GroupMember();
                    $gr->user_id = $user;
                    $gr->group_id = $request->group_id;
                    $gr->save();
                }
            }
        }
        return back();
    }
}
