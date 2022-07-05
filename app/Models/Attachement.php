<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $model_id model id
 * @property varchar $url url
 * @property enum $type type
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Attachement extends Model
{
    const TYPE_MINUTE = 'Minute';

    const TYPE_MEMO = 'Memo';

//    public $incrementing = false;
    /**
     * Database table name
     */
    protected $table = 'attachements';

    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['model_id',
        'url',
        'type'];*/

    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function memo()
    {
        return $this->belongsTo(Memo::class, 'model_id');
    }

    public function attachmentUrl()
    {
        return $this->hasMany(AttachmentUrl::class);
    }

}
