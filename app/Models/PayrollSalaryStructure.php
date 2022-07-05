<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $item_id item id
 * @property enum $type type
 * @property varchar $amount amount
 * @property int $level level
 * @property int $step step
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class PayrollSalaryStructure extends Model
{
    const TYPE_EARNING = 'Earning';

    const TYPE_DEDUCTION = 'Deduction';

    /**
     * Database table name
     */
    protected $table = 'payroll_salary_structures';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['item_id',
        'type',
        'amount',
        'level',
        'step'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    public function totalBasic($level, $step)
    {
        $total = 0;
        $basic = self::where(['level'=>$level, 'step'=>$step,'type'=>'Basic'])->get('amount');
        foreach($basic as $item){
            $total += $item->amount;
        }
        return $total;
    }

    public function totalAllowances($level, $step)
    {
        $total = 0;
        $allowance = self::where(['level'=>$level, 'step'=>$step,'type'=>'Allowance'])->get('amount');
        foreach($allowance as $item){
            $total += $item->amount;
        }
        return $total;
    }

    public function totalDeductions($level, $step)
    {
        $total = 0;
        $deductions = self::where(['level'=>$level, 'step'=>$step, 'type'=>'Deduction'])->get('amount');
        foreach($deductions as $item){
            $total += $item->amount;
        }
        return $total;
    }

    public function item(){
        return $this->belongsTo(PayrollItem::class,'item_id');
    }
}
