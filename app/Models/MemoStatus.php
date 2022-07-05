<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $send_from send from
 * @property bigint $send_to send to
 * @property varchar $model model
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class MemoStatus extends Model
{
    const STATUS_NOT_SEEN = 'not seen';

    const STATUS_SEEN = 'seen';

    const STATUS_READ = 'read';

    const STATUS_COPIED = 'copied';

    /**
     * Database table name
     */
    protected $table = 'memo_statuses';

//    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['send_from',
        'send_to',
        'model',
        'status'];*/
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
