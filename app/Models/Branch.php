<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $department hasMany

 */
class Branch extends Model
{

//    public $incrementing = false;
    /**
    * Database table name
    */
    protected $table = 'branches';

    /**
    * Mass assignable columns
    */
    /*protected $fillable=['name', 'code'];*/
    protected $guarded = [];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * departments
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function departments()
    {
        return $this->hasMany(Department::class,'branch_id');
    }


    public function hasMembers()
    {
        return count($this->departments()->get());
    }


    public function hr_mapping(){
        return $this->hasMany(HrTaskMapping::class, 'branch_id');
    }

    public function staff(){
        return $this->hasMany(UserDetail::class, 'branch_id')->join('users', 'users.id', '=', 'user_details.user_id')->where('users.status', 'active');
    }


    public function salaryStaff(){
        return User::select('users.*', 'payroll_users.id as payroll_user_id')
            ->join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
            ->join('user_details', 'user_details.user_id', '=', 'users.id')
            ->where('payroll_users.status', 'Active')
            ->where('user_details.branch_id',$this->id)
            ->orderBy('users.id', 'asc')->get();
    }

    public function staffWithSalary(){
        $staff = User::selectRaw("
                        users.*,
                        (SELECT CONCAT(surname, ', ', first_name, ' ', IFNULL(other_names, '')) AS fullname FROM user_details WHERE user_id = users.id) fullname,
                        payroll_users.id as payroll_user_id,
                        CONCAT(payroll_users.level, '/',payroll_users.step) AS grade,
                        (SELECT SUM(amount)/12 AS regular FROM payroll_salary_structures ss JOIN payroll_items pi ON ss.item_id = pi.id WHERE (ss.level = payroll_users.level AND ss.step = payroll_users.step) AND ss.type != 'Deduction' AND pi.type = 'Regular') as regular,
                        (SELECT SUM(amount)/12 AS regular FROM payroll_salary_structures ss JOIN payroll_items pi ON ss.item_id = pi.id WHERE (ss.level = payroll_users.level AND ss.step = payroll_users.step) AND ss.type != 'Deduction' AND pi.type = 'Other') as other,
                        (SELECT SUM(amount)/12 AS regular FROM payroll_salary_structures ss JOIN payroll_items pi ON ss.item_id = pi.id WHERE (ss.level = payroll_users.level AND ss.step = payroll_users.step) AND ss.type = 'Deduction' AND pi.type = 'Regular') as deduction,
                        (SELECT SUM(amount) as allowance FROM payroll_allowances pa WHERE payroll_user_id = payroll_users.id) AS other_allowance,
                        (SELECT SUM(amount) as allowance FROM payroll_deductions pd WHERE payroll_user_id = payroll_users.id) AS other_deduction
                    ")
            ->join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
            ->join('user_details', 'user_details.user_id', '=', 'users.id')
            ->where('payroll_users.status', 'Active')
            ->where('user_details.branch_id',$this->id)
            ->orderBy('users.id', 'asc')->get();
        return $staff;
    }

}
