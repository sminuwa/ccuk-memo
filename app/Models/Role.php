<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $permissionRole hasMany
@property \Illuminate\Database\Eloquent\Collection $roleUser hasMany

 */
class Role extends Model
{

    /**
    * Database table name
    */
    protected $table = 'roles';

    public $incrementing = false;
    /**
    * Mass assignable columns
    */
    /*protected $fillable=['name'];*/
    protected $guarded = [];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * permissionRoles
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function permissionRoles()
    {
        return $this->hasMany(PermissionRole::class,'role_id');
    }
    /**
    * roleUsers
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function roleUsers()
    {
        return $this->hasMany(RoleUser::class,'role_id');
    }

    public function activeMembers()
    {
        return count($this->roleUsers()->get());
    }

    public function activePermissions()
    {
        return count($this->permissionRoles()->get());
    }

}
