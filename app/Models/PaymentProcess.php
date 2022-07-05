<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $memo_id memo id
 * @property varchar $account_debited account debited
 * @property varchar $account_credited account credited
 * @property bigint $amount amount
 * @property varchar $beneficiary beneficiary
 * @property varchar $narration narration
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class PaymentProcess extends Model
{

    /**
     * Database table name
     */
    protected $table = 'payment_processes';

    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['memo_id',
        'account_debited',
        'account_credited',
        'amount',
        'beneficiary',
        'narration'];*/

    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];
	
	protected $casts = [
//		'created_at' => 'datetime:Y-m-Y h:i:s',
//		'updated_at' => 'datetime:Y-m-Y h:i:s'
	];
}
