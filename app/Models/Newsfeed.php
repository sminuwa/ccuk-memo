<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $user_id user id
 * @property varchar $subject subject
 * @property text $body body
 * @property bigint $group_id group id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Newsfeed extends Model
{

    /**
     * Database table name
     */
    protected $table = 'newsfeeds';

    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['user_id',
        'subject',
        'body',
        'group_id'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
