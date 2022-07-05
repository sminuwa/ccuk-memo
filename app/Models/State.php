<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $country_id country id
@property varchar $name name
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class State extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'states';

    /**
    * Mass assignable columns
    */
    protected $fillable=['country_id',
'name'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}