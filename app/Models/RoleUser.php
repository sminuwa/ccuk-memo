<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $user_id user id
 * @property bigint $role_id role id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property Role $role belongsTo
 * @property User $user belongsTo
 */
class RoleUser extends Model
{

    /**
     * Database table name
     */
    protected $table = 'role_users';

    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['user_id',
        'role_id'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
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
