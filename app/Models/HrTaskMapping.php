<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $task_id task id
 * @property bigint $branch_id branch id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class HrTaskMapping extends Model
{

    /**
     * Database table name
     */
    protected $table = 'hr_task_mappings';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['task_id',
        'branch_id'];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function task(){
        return $this->belongsTo(HrTask::class, 'task_id');
    }
}
