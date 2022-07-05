<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property longtext $body body
 * @property enum $flag flag
 * @property bigint $from_user from user
 * @property bigint $to_user to user
 * @property enum $confidentiality confidentiality
 * @property text $copy copy
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property ToUser $user belongsTo
 */
class Minute extends Model
{

    use HasFactory, Notifiable;
    const STATUS_NOT_SEEN = 'not seen';

    const STATUS_SEEN = 'seen';

    const STATUS_READ = 'read';

    const CONFIDENTIALITY_CONFIDENTIAL = 'confidential';

    const CONFIDENTIALITY_NOT_CONFIDENTIAL = 'not confidential';

    const FLAG_POSITIVE = 'positive';

    const FLAG_NEGATIVE = 'negative';

    /**
     * Database table name
     */
    protected $table = 'minutes';

//    protected $dateFormat = 'U';

    //public $incrementing = false;

    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['body',
        'flag',
        'from_user',
        'to_user',
        'confidentiality',
        'copy',
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
    /**
     * toUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user');
    }

    /**
     * fromUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    public function attachments(){
        $attachmentObj = Attachement::where('type', 'Minute')->where('model_id', $this->id)->first();
        if($attachmentObj){
            return json_decode($attachmentObj->attachment);
        }

        return null;
    }

    public function hasAttachment(){
        $att = Attachement::where('model_id', $this->id)->where('type', 'Minute')->first();
        if($att)
            return true;
        return false;
    }

    public function attachment(){
        return $this->hasMany(Attachement::class,'model_id')->where('type','=','Minute');
    }
}
