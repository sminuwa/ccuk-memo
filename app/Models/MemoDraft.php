<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $title title
 * @property text $body body
 * @property bigint $user_id user id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class MemoDraft extends Model
{

    /**
     * Database table name
     */
    protected $table = 'memo_drafts';

    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['title',
        'body',
        'user_id'];*/
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
