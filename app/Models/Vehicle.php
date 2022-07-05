<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property varchar $color color
 * @property varchar $model model
 * @property varchar $cassis cassis
 * @property enum $fuel fuel
 * @property enum $new_second new second
 * @property date $date_bought date bought
 * @property varchar $amount_bought amount bought
 * @property bigint $category_id category id
 * @property varchar $vehicle_type_id vehicle type id
 * @property varchar $tonnage tonnage
 * @property enum $status status
 * @property enum $has_driver has driver
 * @property enum $has_external_body has external body
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Vehicle extends Model
{
    const HAS_EXTERNAL_BODY_YES = 'Yes';

    const HAS_EXTERNAL_BODY_NO = 'No';

    const HAS_DRIVER_YES = 'Yes';

    const HAS_DRIVER_NO = 'No';

    const STATUS_REPAIR = 'Repair';

    const STATUS_ROUTINE_MAINTENANCE = 'Routine Maintenance';

    const STATUS_ACCIDENT = 'Accident';

    const STATUS_IN_TRANSIT = 'In Transit';

    const STATUS_IDLE = 'Idle';

    const NEW_SECOND_NEW = 'New';

    const NEW_SECOND_SECOND = 'Second';

    const FUEL_DIESEL = 'Diesel';

    const FUEL_PETROL = 'Petrol';

    /**
     * Database table name
     */
    protected $table = 'vehicles';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name',
        'color',
        'model',
        'cassis',
        'fuel',
        'new_second',
        'date_bought',
        'amount_bought',
        'category_id',
        'vehicle_type_id',
        'tonnage',
        'status',
        'has_driver',
        'has_external_body'];

    /**
     * Date time columns.
     */
    protected $dates = ['date_bought'];


    public function activeDriver(){
        return VehicleDriver::where(['vehicle_id'=>$this->id, 'status'=> VehicleDriver::STATUS_ACTIVE])->first();
    }

    public function drivers(){
        return $this->hasMany(VehicleDriver::class)->orderBy('id','desc');
    }

    public function activeDispatch(){
        $vehicleDrivers = $this->drivers()->pluck('id')->toArray();
        return VehicleDispatch::whereIn('vehicle_driver_id', $vehicleDrivers)->where('date_to', null)->where('status','!=',VehicleDispatch::STATUS_CLOSED)->first();
    }

    public function dispatches(){
        $drivers = $this->drivers->pluck('id')->toArray();
        return VehicleDispatch::whereIn('vehicle_driver_id', $drivers)->orderBy('id', 'desc')->get();
    }

    public function getDispatchForms(){

    }

    public function fuels(){

    }

    public function status(){
        return $this->status;
    }

    public function getCost(){
        if(auth()->user()->canAccess('vehicle.cost')) return number_format($this->cost);
        return "*****";
    }

    public function getRevenue(){
//        if(auth()->user()->canAccess('vehicle.revenue')) {
        $total = [];
        foreach($this->dispatches() as $dispatch){
            $total[] = $dispatch->getTotalRevenue();
        }
        return array_sum($total);
//        }
//        return "*****";
    }

    public function getExpense(){
//        if(auth()->user()->canAccess('vehicle.expense')) {
        $total = [];
        foreach($this->dispatches() as $dispatch){
            $total[] = $dispatch->getTotalExpense();
        }
        return array_sum($total);
//        }
//        return "*****";
    }

    public function getTotalDriverPercentage(){
        $total = [];
        foreach($this->dispatches() as $dispatch){
            $total[] = $dispatch->driverPercentage();
        }
        return array_sum($total);
    }

    public function particulars(){
        return $this->hasMany(VehicleParticular::class)->orderBy('id', 'desc');
    }

    public function getParticularExpiryDate(){
        if($this->particulars != null && count($this->particulars) == 0) return '<span class="text-danger">No Particulars</span>';
    }

    public function getFuel(){
        if($fuel = FuelPrice::where(['date_to'=> null, 'name'=>$this->fuel])->first()) return $fuel;
        return 0;
    }

    public function repair(){

    }

    public function driverPercentage(){
       return  VehicleConfiguration::where('name', 'driver-percentage')->first();
    }

    public function hasOpeningBalance(){
        $transactions = Transaction::where(['model_name'=> class_basename($this), 'model_id'=> $this->id])->count();
        if(!$transactions) return false;
        return true;
    }

    public function maintenances(){
        return $this->hasMany(VehicleMaintenance::class, 'vehicle_id')->orderBy('id', 'desc');
    }

    public function statements(){
        $statements = Transaction::where('account', $this->account()->number)->orderBy('id','desc')->get();
        return $statements;
    }

    public function account(){
        return AccountNumber::where(['model_id'=>$this->id,'model_name'=>class_basename($this)])->first();
    }

}
