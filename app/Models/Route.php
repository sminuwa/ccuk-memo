<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property varchar $direction direction
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Route extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'routes';

    /**
    * Mass assignable columns
    */
    protected $fillable=['name',
'direction'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}