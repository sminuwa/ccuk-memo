<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property bigint $user_id user id
 * @property varchar $surname surname
 * @property varchar $first_name first name
 * @property varchar $other_names other names
 * @property enum $gender gender
 * @property enum $marital_status marital status
 * @property int $current_level current level
 * @property text $permanent_address permanent address
 * @property text $contact_address contact address
 * @property varchar $personnel_number personnel number
 * @property bigint $department_id department id
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property Department $department belongsTo
 * @property User $user belongsTo
 */
class UserDetail extends Model
{
    use HasFactory, Notifiable;
    const STATUS_ACTIVE = 'active';

    const STATUS_FIRED = 'fired';

    const STATUS_RETIRED = 'retired';

    const STATUS_RESIGNED = 'resigned';

    const STATUS_DECEASED = 'deceased';

    const MARITAL_STATUS_DIVORCED = 'Divorced';

    const MARITAL_STATUS_MARRIED = 'Married';

    const MARITAL_STATUS_SINGLE = 'Single';

    const MARITAL_STATUS_WIDOWED = 'Widowed';

    const MARITAL_STATUS_SEPARATED = 'Separated';

    const GENDER_MALE = 'Male';

    const GENDER_FEMALE = 'Female';

    public $incrementing = false;
    /**
     * Database table name
     */
    protected $table = 'user_details';

    /**
     * Mass assignable columns
     */
   /* protected $fillable = ['user_id',
        'surname',
        'first_name',
        'other_names',
        'gender',
        'marital_status',
        'current_level',
        'permanent_address',
        'contact_address',
        'personnel_number',
        'department_id',
        'status'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
