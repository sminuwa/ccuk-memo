<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $memo_id memo id
 * @property bigint $vehicle_driver_id vehicle driver id
 * @property varchar $number number
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class VehicleDispatch extends Model
{
    const STATUS_OPENED = 'Opened';

    const STATUS_VERIFIED = 'Verified';

    const STATUS_APPROVED = 'Approved';

    const STATUS_AUTHORIZED = 'Authorized';

    const STATUS_CLOSED = 'Closed';

    /**
     * Database table name
     */
    protected $table = 'vehicle_dispatches';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['memo_id',
        'vehicle_driver_id',
        'number',
        'status'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    public function vehicleDriver(){
        return $this->belongsTo(VehicleDriver::class)->orderBy('id', 'desc');
    }

    public function memo(){
        return $this->belongsTo(Memo::class);
    }

    public function opened(){
        return self::where('status', self::STATUS_OPENED)->get();
    }

    public function verified(){
        return self::where('status', self::STATUS_VERIFIED)->get();
    }

    public function approved(){
        return self::where('status', self::STATUS_APPROVED)->get();
    }

    public function authorized(){
        return self::where('status', self::STATUS_AUTHORIZED)->get();
    }

    public function getStatus(){
        if($this->status == self::STATUS_OPENED) return '<span class="badge badge-dark">Opened</span>';
        if($this->status == self::STATUS_AUTHORIZED) return '<span class="badge badge-info">Authorized</span>';
        if($this->status == self::STATUS_APPROVED) return '<span class="badge badge-success">Approved</span>';
        if($this->status == self::STATUS_VERIFIED) return '<span class="badge badge-warning">Verified</span>';
        if($this->status == self::STATUS_CLOSED) return '<span class="badge badge-danger">Closed</span>';
    }

    public static function generateNewNumber(){
        $num = self::orderBy('id', 'desc')->first();
        if($num) return 'DT'.str_pad(substr($num->number,2, 5)+1, 5, 0,STR_PAD_LEFT);
        return 'DT00001';
    }

    public function activeDispatch(){
        return self::where(['status','!='=>self::STATUS_CLOSED, 'date_to'=>null])->first();
    }

    public function totalForms(){
        return $this->forms()->count();
    }

    public function forms(){
//        $forms = VehicleDispatchForm::where('vehicle_dispatch_id', $this->id)->where('type', '!=',VehicleDispatchForm::TYPE_DISPATCH);
        return $this->hasMany(VehicleDispatchForm::class, 'vehicle_dispatch_id');
    }

    public function revenueForms(){
        return $this->forms()->where('category', VehicleDispatchForm::CATEGORY_REVENUE);
//        return $revenueForms;
    }

    public function getTotalRevenue(){
        $forms = $this->forms()->get();
        $amount = [];
        foreach($forms as $form){
            $data = json_decode($form->data);
            switch($form->type){
                case VehicleDispatchForm::TYPE_DISPATCH:
                    $amount[] = $data->cost;
                    break;
                case VehicleDispatchForm::TYPE_CARRIAGE:
                    $amount[] = $data->cost;
                    break;
                default:
                    $amount[] = 0;
            }
        }
        if(array_sum($amount) > 0)
            return array_sum($amount);
        return 0;
    }

    public function getTotalExpense(){
        $forms = $this->forms()->get();
        $amount = [];
        foreach($forms as $form){
            $data = json_decode($form->data);
            switch($form->type){
                case VehicleDispatchForm::TYPE_DISPATCH:
                    $amount[] = $data->amount;
                    break;
                case VehicleDispatchForm::TYPE_FUEL:
                    $amount[] = $data->amount;
                    break;
                default:
                    $amount[] = 0;
            }
        }
        if(array_sum($amount) > 0)
            return array_sum($amount);
        return 0;
    }

    public function driverPercentage(){
        $amount = intval($this->getTotalRevenue()) - intval($this->getTotalExpense());
        $percent = VehicleConfiguration::where(['name'=>'driver-percentage','status'=>'active'])->first()->value ?? 0;
        return ($amount/100) * $percent;
//        return (10/$amount) * 100;
    }

    public function driver(){
        return $this->belongsTo(VehicleDriver::class, 'vehicle_driver_id');
    }

}
