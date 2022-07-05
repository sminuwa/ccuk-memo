<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleParticular;


/**
 * Description of VehicleParticularController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class VehicleParticularController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.vehicle_particulars.index', ['records' => VehicleParticular::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  VehicleParticular  $vehicleparticular
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, VehicleParticular $vehicleparticular)
    {
        return view('pages.vehicle_particulars.show', [
                'record' =>$vehicleparticular,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.vehicle_particulars.create', [
            'model' => new VehicleParticular,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new VehicleParticular;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'VehicleParticular saved successfully');
            return redirect()->route('vehicle_particulars.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving VehicleParticular');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  VehicleParticular  $vehicleparticular
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, VehicleParticular $vehicleparticular)
    {

        return view('pages.vehicle_particulars.edit', [
            'model' => $vehicleparticular,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  VehicleParticular  $vehicleparticular
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,VehicleParticular $vehicleparticular)
    {
        $vehicleparticular->fill($request->all());

        if ($vehicleparticular->save()) {
            
            session()->flash('app_message', 'VehicleParticular successfully updated');
            return redirect()->route('vehicle_particulars.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating VehicleParticular');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  VehicleParticular  $vehicleparticular
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, VehicleParticular $vehicleparticular)
    {
        if ($vehicleparticular->delete()) {
                session()->flash('app_message', 'VehicleParticular successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting VehicleParticular');
            }

        return redirect()->back();
    }
}
