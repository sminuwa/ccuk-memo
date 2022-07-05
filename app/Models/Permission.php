<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $permissionRole hasMany
@property \Illuminate\Database\Eloquent\Collection $permissionUser hasMany
   
 */
class Permission extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'permissions';

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
        return $this->hasMany(PermissionRole::class,'permission_id');
    }
    /**
    * permissionUsers
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function permissionUsers()
    {
        return $this->hasMany(PermissionUser::class,'permission_id');
    }



}
