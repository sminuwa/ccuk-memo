<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property varchar $value value
@property varchar $type type
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class VehicleConfiguration extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'vehicle_configurations';

    /**
    * Mass assignable columns
    */
    protected $fillable=['name',
'value',
'type'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}