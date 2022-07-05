<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $memo_id memo id
 * @property enum $approval approval
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class MemoApproval extends Model
{
    const APPROVAL_PAYMENT = 'Payment';

    const APPROVAL_VEHICLE = 'Vehicle';

    /**
     * Database table name
     */
    protected $table = 'memo_approvals';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['memo_id',
        'approval'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    public function approvedBy(){
        return $this->belongsTo(User::class,'approved_by');
    }

    public function authorizedBy(){
        return $this->belongsTo(User::class,'authorized_by');
    }

    public function verifiedBy(){
        return $this->belongsTo(User::class,'verified_by');
    }

    public function checkedBy(){
        return $this->belongsTo(User::class,'checked_by');
    }

}
