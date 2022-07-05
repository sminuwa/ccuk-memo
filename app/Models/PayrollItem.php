<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class PayrollItem extends Model
{

    /**
     * Database table name
     */
    protected $table = 'payroll_items';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    public function scopeItemReports($query){
        return $query->selectRaw("
                payroll_items.code,
                payroll_items.name,
                payroll_items.type AS category,
                pss.type AS type,
                ROUND(sum(pss.amount)/12, 2) AS mtd,
                (SELECT SUM(amount) FROM payroll_payslips pp WHERE pp.item = payroll_items.name) AS ytd
            ")
            ->leftJoin('payroll_salary_structures as pss', 'pss.item_id', '=', 'payroll_items.id')
            ->groupBy('payroll_items.name');
    }

    public function scopeOtherAllowanceItemReports($query){
        return $query->selectRaw("
                payroll_items.code,
                payroll_items.name,
                payroll_items.type AS category,
                pss.type AS type,
                ROUND(sum(pss.amount)/12, 2) AS mtd,
                (SELECT SUM(amount) FROM payroll_payslips pp WHERE pp.item = payroll_items.name) AS ytd
            ")
            ->leftJoin('payroll_salary_structures as pss', 'pss.item_id', '=', 'payroll_items.id')
            ->groupBy('payroll_items.name');
    }

    public function scopeItemReportsPendingFund($query){
        return $query->selectRaw("
                payroll_items.code,
                payroll_items.name,
                payroll_items.type AS category,
                pss.type AS type,
                ROUND(sum(pss.amount)/12, 2) AS mtd,
                (SELECT SUM(amount) FROM payroll_payslips pp WHERE pp.item = payroll_items.name) AS ytd
            ")
            ->leftJoin('payroll_salary_structures as pss', 'pss.item_id', '=', 'payroll_items.id')
            ->groupBy('payroll_items.name');
    }

    public function scopeStaffPerItem($query){
        return $query->whereRaw("

        ")
            ->where('payroll_items.id', $this->id)
            ->join('payroll_users', 'payroll_users.id');
    }

    public function scopeConfirmedStaff($query){
        return $query->where('payroll_users.status', PayrollUser::CONFIRMED)
            ->join('');
    }




}
