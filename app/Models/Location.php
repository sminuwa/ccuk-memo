<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property text $coordinate coordinate
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Location extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'locations';

    /**
    * Mass assignable columns
    */
    protected $fillable=['name',
'coordinate'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}