<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property bigint $vehicle_id vehicle id
@property date $issue_date issue date
@property date $expiry_date expiry date
@property enum $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class VehicleParticular extends Model 
{
    const STATUS_ACTIVE='active';

const STATUS_INACTIVE='inactive';

    /**
    * Database table name
    */
    protected $table = 'vehicle_particulars';

    /**
    * Mass assignable columns
    */
    protected $fillable=['name',
'vehicle_id',
'issue_date',
'expiry_date',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=['issue_date',
'expiry_date'];




}