<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $item item
 * @property enum $type type
 * @property decimal $amount amount
 * @property date $date date
 * @property bigint $user_id user id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class PayrollPayslip extends Model
{
    const TYPE_EARNING = 'Earning';

    const TYPE_DEDUCTION = 'Deduction';

    /**
     * Database table name
     */
    protected $table = 'payroll_payslips';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['item',
        'type',
        'amount',
        'date',
        'user_id'];

    /**
     * Date time columns.
     */
    protected $dates = ['date'];


    public function scopeItemReport($query){
        return $query->selectRaw("payroll_payslips.*, users.id as user_id, user_details.personnel_number, CONCAT(user_details.surname,' ', IFNULL(user_details.first_name, ''),' ', IFNULL(user_details.other_names,'')) AS fullname")
            ->join('payroll_users', 'payroll_payslips.payroll_user_id', '=', 'payroll_users.id')
            ->join('users', 'payroll_users.user_id', '=', 'users.id')
            ->join('user_details','users.id','=','user_details.user_id');
    }

    public function scopeStaffReport($query){
        return $query->selectRaw("payroll_payslips.*, users.id as user_id, user_details.personnel_number, CONCAT(user_details.surname,' ', IFNULL(user_details.first_name, ''),' ', IFNULL(user_details.other_names,'')) AS fullname")
            ->join('payroll_users', 'payroll_payslips.payroll_user_id', '=', 'payroll_users.id')
            ->join('users', 'payroll_users.user_id', '=', 'users.id')
            ->join('user_details','users.id','=','user_details.user_id');
    }

    public function scopeMonth($query, string $date){
        return $query->where('payroll_payslips.date', 'like','%'.$date.'%');
    }

    public function scopeYear($query, string $year){

    }

    public function scopeItem($query, string $item){
        return $query->where('payroll_items.name', $item)
            ->selectRaw('payroll_items.code as item_code')
            ->join('payroll_items', 'payroll_items.name','=', 'payroll_payslips.item');
    }

    public function scopeType($query, string $type){
        return $query->where('payroll_payslips.type', $type);
    }

    public function scopeTypeNot($query, string $type){
        return $query->where('payroll_payslips.type', '!=', $type);
    }

    public function scopeCategory($query, string $category){
        return $query->where('payroll_payslips.category', $category);
    }

    public function scopeCategoryNot($query, string $category){
        return $query->where('payroll_payslips.category', '!=', $category);
    }

    public function scopeStaff($query, int $staff_id){
        return $query->where('users.id', $staff_id);
    }

    public function scopeConfirmedStaff($query){
        return $query->where('payroll_users.confirmation', PayrollUser::CONFIRMED);
    }

    public function scopeNotConfirmedStaff($query){
        return $query->where('payroll_users.confirmation', '!=', PayrollUser::CONFIRMED);
    }

    public function scopeJoinStaff($query){
        return $query->join('payroll_users', 'payroll_payslips.payroll_user_id', '=','payroll_users.id')
            ->join('users', 'payroll_users.user_id', '=', 'users.id')
            ->join('user_details', 'users.id', '=', 'user_details.user_id');
    }

    public function scopeItemSummary($query, string $year){
        return $query->selectRaw("
                payroll_payslips.*,
                sum(amount) as mtd,
                (SELECT SUM(amount) FROM payroll_payslips pp WHERE pp.date like '%$year%' AND item = payroll_payslips.item) AS ytd,
                (SELECT SUM(amount)
                    FROM payroll_payslips pp
                    JOIN payroll_users pu ON pp.payroll_user_id = pu.id
                    WHERE pp.date like '%$year%'
                        AND item = payroll_payslips.item
                        AND pu.confirmation = 'Confirmed'
                        AND pp.category = 'Regular'
                        AND pp.type != 'Deduction')
                    AS pytd
            ")
            ->selectRaw('payroll_items.code as item_code')
            ->join('payroll_items', 'payroll_items.name','=', 'payroll_payslips.item')
            ->groupBy('payroll_payslips.item');
    }

    public function scopeBranch($query, array $branch_ids){
        return $query->join('branches', 'user_details.branch_id', '=', 'branches.id')
            ->whereIn('branches.id',$branch_ids)
            ->selectRaw("branches.id AS branch_id, branches.name AS branch_name");
    }

}
