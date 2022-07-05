<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $memo_id memo id
 * @property varchar $type type
 * @property text $data data
 * @property enum $accept_retirements accept retirements
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property string has_payments
 */
class Form extends Model
{
    const ACCEPT_RETIREMENTS_YES = 'Yes';

    const ACCEPT_RETIREMENTS_NO = 'No';

    const HAS_PAYMENT_YES = 'Yes';

    const HAS_PAYMENT_NO = 'No';

    /**
     * Database table name
     */
    protected $table = 'forms';

    public $incrementing = false;

    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['memo_id',
        'type',
        'data',
        'accept_retirements'];*/
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
