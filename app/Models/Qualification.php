<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $qualification qualification
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Qualification extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'qualifications';

    /**
    * Mass assignable columns
    */
    protected $fillable=['qualification'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}