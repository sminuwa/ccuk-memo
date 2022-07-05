<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleDriver;


/**
 * Description of VehicleDriverController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class VehicleDriverController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.vehicle_drivers.index', ['records' => VehicleDriver::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  VehicleDriver  $vehicledriver
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, VehicleDriver $vehicledriver)
    {
        return view('pages.vehicle_drivers.show', [
                'record' =>$vehicledriver,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.vehicle_drivers.create', [
            'model' => new VehicleDriver,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new VehicleDriver;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'VehicleDriver saved successfully');
            return redirect()->route('vehicle_drivers.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving VehicleDriver');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  VehicleDriver  $vehicledriver
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, VehicleDriver $vehicledriver)
    {

        return view('pages.vehicle_drivers.edit', [
            'model' => $vehicledriver,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  VehicleDriver  $vehicledriver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,VehicleDriver $vehicledriver)
    {
        $vehicledriver->fill($request->all());

        if ($vehicledriver->save()) {
            
            session()->flash('app_message', 'VehicleDriver successfully updated');
            return redirect()->route('vehicle_drivers.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating VehicleDriver');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  VehicleDriver  $vehicledriver
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, VehicleDriver $vehicledriver)
    {
        if ($vehicledriver->delete()) {
                session()->flash('app_message', 'VehicleDriver successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting VehicleDriver');
            }

        return redirect()->back();
    }
}
