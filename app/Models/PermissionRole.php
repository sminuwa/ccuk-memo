<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $role_id role id
@property bigint $permission_id permission id
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property Permission $permission belongsTo
@property Role $role belongsTo
   
 */
class PermissionRole extends Model 
{
    public $incrementing = false;
    /**
    * Database table name
    */
    /*protected $table = 'permission_roles';*/
    protected $guarded = [];

    /**
    * Mass assignable columns
    */
    protected $fillable=['role_id',
'permission_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * permission
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function permission()
    {
        return $this->belongsTo(Permission::class,'permission_id');
    }

    /**
    * role
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }




}
