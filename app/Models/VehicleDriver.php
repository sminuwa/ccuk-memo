<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $vehicle_id vehicle id
 * @property bigint $driver_id driver id
 * @property date $from_date from date
 * @property date $to_date to date
 * @property enum $type type
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class VehicleDriver extends Model
{
    const STATUS_ACTIVE = 'active';

    const STATUS_INACTIVE = 'inactive';

    const TYPE_MAIN = 'Main';

    const TYPE_SPIRE = 'Spire';

    /**
     * Database table name
     */
    protected $table = 'vehicle_drivers';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['vehicle_id',
        'driver_id',
        'from_date',
        'to_date',
        'type',
        'status'];

    /**
     * Date time columns.
     */
    /*protected $dates = ['from_date',
        'to_date'];*/


    public function driver(){
//        return User::find($this->user_id);
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

}
