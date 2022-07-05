<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class FormParticular extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'form_particulars';

    public $incrementing = false;
    /**
    * Mass assignable columns
    */
    /*protected $fillable=['name'];*/
    protected $guarded = [];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
