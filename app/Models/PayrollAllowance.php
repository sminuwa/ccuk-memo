<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $payroll_user_id payroll user id
@property varchar $name name
@property date $month month
@property decimal $amount amount
@property varchar $description description
@property timestamp $create_at create at
@property timestamp $updated_at updated at

 */
class PayrollAllowance extends Model
{

    /**
    * Database table name
    */
    protected $table = 'payroll_allowances';

    /**
    * Mass assignable columns
    */
    protected $fillable=['payroll_user_id',
'name',
'month',
'amount',
'description',
'create_at'];

    /**
    * Date time columns.
    */
    protected $dates=['month',
'create_at'];


    public function item()
    {
        return $this->belongsTo(PayrollItem::class, 'item_id');
    }

}
