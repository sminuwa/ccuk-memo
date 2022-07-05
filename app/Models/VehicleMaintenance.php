<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $vehicle_id vehicle id
 * @property enum $type type
 * @property varchar $description description
 * @property varchar $amount amount
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class VehicleMaintenance extends Model
{
    const TYPE_ROUTINE = 'Routine';

    const TYPE_OTHER = 'Other';

    /**
     * Database table name
     */
    protected $table = 'vehicle_maintenances';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['vehicle_id',
        'type',
        'description',
        'amount'];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public static function generateNewNumber(){
        $num = self::orderBy('id', 'desc')->first();
        $num2 = intval(substr($num->reference,2, 5))+1;
        if($num) return 'MT'.str_pad($num2, 5, 0,STR_PAD_LEFT);
        return 'MT00001';
    }

    public function memo(){
        return $this->belongsTo(Memo::class);
    }

    public function transactions(){
        return Transaction::where(['reference_model'=>class_basename($this), 'reference_id'=>$this->id])->first();
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

}
