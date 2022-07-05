<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StaffPosition;
use App\Models\User;
use App\Models\Position;


/**
 * Description of StaffPositionController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class StaffPositionController extends Controller
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
        return view('pages.staff_positions.index', ['records' => StaffPosition::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  StaffPosition  $staffposition
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StaffPosition $staffposition)
    {
        return view('pages.staff_positions.show', [
                'record' =>$staffposition,
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
		$positions = Position::all(['id']);

        return view('pages.staff_positions.create', [
            'model' => new StaffPosition,
			"users" => $users,
			"positions" => $positions,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new StaffPosition;
        $model->id = newId();
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'StaffPosition saved successfully');
            return redirect()->route('staff_positions.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving StaffPosition');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  StaffPosition  $staffposition
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, StaffPosition $staffposition)
    {
		$users = User::all(['id']);
		$positions = Position::all(['id']);

        return view('pages.staff_positions.edit', [
            'model' => $staffposition,
			"users" => $users,
			"positions" => $positions,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  StaffPosition  $staffposition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,StaffPosition $staffposition)
    {
        $staffposition->fill($request->all());

        if ($staffposition->save()) {

            session()->flash('app_message', 'StaffPosition successfully updated');
            return redirect()->route('staff_positions.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating StaffPosition');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  StaffPosition  $staffposition
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, StaffPosition $staffposition)
    {
        if ($staffposition->delete()) {
                session()->flash('app_message', 'StaffPosition successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting StaffPosition');
            }

        return redirect()->back();
    }
}
