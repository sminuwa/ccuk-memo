<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Position;


/**
 * Description of PositionController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class PositionController extends Controller
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
        return view('pages.positions.index', ['records' => Position::orderBy('name', 'asc')->get()]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Position $position)
    {
        return view('pages.positions.show', [
                'record' =>$position,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.positions.create', [
            'model' => new Position,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
        $model=new Position;
        $model->id = newId();
        if($request->p_id)
            $model =Position::find($request->p_id);
        $model->fill($request->all());

        if ($model->save()) {
            //activity()->on($model)->log('Position created / edited');
            session()->flash('app_message', 'Position saved successfully');
            return redirect()->route('position.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Position');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Position $position)
    {

        return view('pages.positions.edit', [
            'model' => $position,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Position $position)
    {
        $position->fill($request->all());

        if ($position->save()) {

            session()->flash('app_message', 'Position successfully updated');
            return redirect()->route('positions.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Position');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  Position  $position
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $position=Position::find($id);
        if ($position->delete()) {
                session()->flash('app_message', 'Position successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Position');
            }

        return redirect()->back();
    }


}
