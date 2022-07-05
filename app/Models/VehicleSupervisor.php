<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $vehicle_id vehicle id
@property bigint $user_id user id
@property date $date_from date from
@property date $date_to date to
@property int $created_at created at
@property int $updated_at updated at
   
 */
class VehicleSupervisor extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'vehicle_supervisors';

    /**
    * Mass assignable columns
    */
    protected $fillable=['vehicle_id',
'user_id',
'date_from',
'date_to'];

    /**
    * Date time columns.
    */
    protected $dates=['date_from',
'date_to'];




}