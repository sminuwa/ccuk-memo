<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $task_mapping_id task mapping id
@property bigint $staff_id staff id
@property datetime $time_from time from
@property datetime $time_to time to
@property enum $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class HrTaskSchedule extends Model 
{
    const STATUS_PENDING='pending';

const STATUS_COMPLETED='completed';

const STATUS_SUSPENDED='suspended';

const STATUS_POSTPONED='postponed';

    /**
    * Database table name
    */
    protected $table = 'hr_task_schedules';

    /**
    * Mass assignable columns
    */
    protected $fillable=['task_mapping_id',
'staff_id',
'time_from',
'time_to',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=['time_from',
'time_to'];




}