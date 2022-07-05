<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property varchar $address address
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Bank extends Model
{

    /**
     * Database table name
     */
    protected $table = 'banks';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name',
        'address'];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function salaryStaff(){
        return User::select('users.*','b.name as bank', 'pu.account_number')
            ->join('payroll_users as pu', 'users.id', '=', 'pu.user_id')
            ->join('user_details as ud', 'ud.user_id', '=', 'users.id')
            ->join('banks as b', 'b.id', '=', 'pu.bank_id')
            ->where(['pu.status'=>'Active','bank_id'=>$this->id])
            ->orderBy('users.id', 'asc')->get();
    }

}
