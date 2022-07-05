<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $item_id item id
@property enum $type type
@property decimal $amount amount
@property bigint $user_id user id
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class PayrollPaystub extends Model 
{
    const TYPE_EARNING='Earning';

const TYPE_DEDUCTION='Deduction';

    /**
    * Database table name
    */
    protected $table = 'payroll_paystubs';

    /**
    * Mass assignable columns
    */
    protected $fillable=['item_id',
'type',
'amount',
'user_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}