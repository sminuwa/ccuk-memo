<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $description description
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class StaffCode extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'staff_codes';

    /**
    * Mass assignable columns
    */
    protected $fillable=['code',
'description'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}