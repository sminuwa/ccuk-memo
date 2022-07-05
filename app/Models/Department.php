<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property varchar $name name
 * @property bigint $branch_id branch id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property Branch $branch belongsTo
 */
class Department extends Model
{

    use HasFactory, Notifiable;
    /**
     * Database table name
     */
    protected $table = 'departments';

//    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['name',
        'branch_id'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * branch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->first();
    }

    public function staff()
    {
        return $this->hasMany(UserDetail::class, 'department_id');
    }

    public function hasMembers()
    {
        return count($this->staff()->get());
    }
}
