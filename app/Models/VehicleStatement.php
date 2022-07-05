<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $vehicle_dispatch_form_id vehicle dispatch form id
@property enum $type type
@property decimal $amount amount
@property int $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class VehicleStatement extends Model 
{
    const TYPE_EXPENSE='expense';

const TYPE_REVENUE='revenue';

    /**
    * Database table name
    */
    protected $table = 'vehicle_statements';

    /**
    * Mass assignable columns
    */
    protected $fillable=['vehicle_dispatch_form_id',
'type',
'amount',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}