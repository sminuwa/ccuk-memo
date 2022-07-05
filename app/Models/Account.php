<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $owner_id owner id
@property varchar $owner owner
@property varchar $account_number account number
@property decimal $amount amount
@property decimal $last_amount last amount
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Account extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'accounts';

    /**
    * Mass assignable columns
    */
    protected $fillable=['owner_id',
'owner',
'account_number',
'amount',
'last_amount'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}