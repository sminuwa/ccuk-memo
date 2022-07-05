<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $sender sender
 * @property int $receiver receiver
 * @property text $message message
 * @property enum $seen seen
 * @property timestamp $deleted_at deleted at
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Message extends Model
{
    const SEEN_YES = 'yes';

    const SEEN_NO = 'no';

    /**
     * Database table name
     */
    protected $table = 'messages';

    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['sender',
        'receiver',
        'message',
        'seen'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function sender(){

    }

    public function receiver(){

    }

    public function category(){
        $category = $this->belongsTo(Department::class, 'department_id');
        return $category;
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

}
