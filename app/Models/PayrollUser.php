<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $user_id user id
 * @property int $level level
 * @property int $step step
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class PayrollUser extends Model
{
    const STATUS_1 = '1';

    const STATUS_0 = '0';

    const STATUS_ACTIVE = 'Active';

    const STATUS_SUSPENDED = 'Suspended';

    const CONFIRMED = 'Confirmed';

    /**
     * Database table name
     */
    protected $table = 'payroll_users';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['user_id',
        'level',
        'step',
        'status'];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
