<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $model_id model id
 * @property varchar $model model
 * @property enum $status status
 * @property timestamp $sync_date sync date
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class SyncTable extends Model
{
    const STATUS_LOCAL = 'local';

    const STATUS_CLOUD = 'cloud';

    public $incrementing = false;
    /**
     * Database table name
     */
    protected $table = 'sync_tables';

    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['model_id',
        'model',
        'status',
        'sync_time'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = ['sync_date'];


}
