<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $code code
 * @property varchar $name name
 * @property varchar $description description
 * @property int $duration duration
 * @property int $point point
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class HrTask extends Model
{
    const STATUS_0 = '0';

    const STATUS_1 = '1';

    /**
     * Database table name
     */
    protected $table = 'hr_tasks';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['code',
        'name',
        'description',
        'duration',
        'point',
        'status'];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function status(){
        if($this->status == 1) return '<span class="badge badge-rounded badge-success">active</span>';
        if($this->status == 0) return '<span class="badge badge-rounded badge-danger">disable</span>';
    }

}
