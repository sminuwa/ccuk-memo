<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $model_id model id
@property varchar $model_name model name
@property varchar $name name
@property varchar $number number
@property enum $has_limit has limit
@property decimal $account_limit account limit
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property decimal $capital capital
   
 */
class AccountNumber extends Model 
{
    const HAS_LIMIT_YES='Yes';

const HAS_LIMIT_NO='No';

    /**
    * Database table name
    */
    protected $table = 'account_numbers';

    /**
    * Mass assignable columns
    */
    protected $fillable=['capital',
'model_id',
'model_name',
'name',
'number',
'has_limit',
'account_limit',
'capital'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}