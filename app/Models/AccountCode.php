<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $description description
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class AccountCode extends Model 
{
    public $incrementing = false;
    /**
    * Database table name
    */
    protected $table = 'account_codes';

    /**
    * Mass assignable columns
    */
    /*protected $fillable=['code',
'description'];*/
    protected $guarded = [];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
