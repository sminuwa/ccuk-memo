<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $user_id user id
 * @property bigint $permission_id permission id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property Permission $permission belongsTo
 * @property User $user belongsTo
 */
class PermissionUser extends Model
{

    /**
     * Database table name
     */
    protected $table = 'permission_users';

    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['user_id',
        'permission_id'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
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
