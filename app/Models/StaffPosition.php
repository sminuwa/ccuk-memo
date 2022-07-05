<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $staff_id staff id
 * @property bigint $postion_id postion id
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property Postion $position belongsTo
 * @property Staff $user belongsTo
 */
class StaffPosition extends Model
{
    const STATUS_CURRENT = 'current';

    const STATUS_OLD = 'old';

    /**
     * Database table name
     */
    protected $table = 'staff_positions';

    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['staff_id',
        'postion_id',
        'status'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * postion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postion()
    {
        return $this->belongsTo(Position::class, 'postion_id');
    }

    /**
     * staff
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }


}
