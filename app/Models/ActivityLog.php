<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $log_name log name
 * @property text $description description
 * @property varchar $subject_type subject type
 * @property bigint $subject_id subject id
 * @property varchar $causer_type causer type
 * @property bigint $causer_id causer id
 * @property longtext $properties properties
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class ActivityLog extends Model
{

    public $incrementing = false;
    /**
     * Database table name
     */
    protected $table = 'activity_log';

    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties'];*/

    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
