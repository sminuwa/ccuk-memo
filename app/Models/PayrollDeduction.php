<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $payroll_user_id payroll user id
 * @property bigint $item_id item id
 * @property date $start_date start date
 * @property int $installment installment
 * @property decimal $amount amount
 * @property varchar $description description
 * @property timestamp $create_at create at
 * @property timestamp $updated_at updated at
 */
class PayrollDeduction extends Model
{

    /**
     * Database table name
     */
    protected $table = 'payroll_deductions';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['payroll_user_id',
        'item_id',
        'start_date',
        'installment',
        'amount',
        'description',
        'create_at'];

    /**
     * Date time columns.
     */
    protected $dates = ['start_date',
        'create_at'];

    public function item()
    {
        return $this->belongsTo(PayrollItem::class, 'item_id');
    }


}
