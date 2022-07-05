<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $description description
@property varchar $gcca gcca
@property enum $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class AccountLedger extends Model 
{
    const STATUS_1='1';

const STATUS_0='0';

    /**
    * Database table name
    */
    protected $table = 'account_ledgers';

    /**
    * Mass assignable columns
    */
    protected $fillable=['code',
'description',
'gcca',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}