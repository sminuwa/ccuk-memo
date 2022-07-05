<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $memo_id memo id
 * @property bigint $vehicle_dispatch_id vehicle dispatch id
 * @property enum $type type
 * @property enum $category category
 * @property enum $has_payment has payment
 * @property int $amount amount
 * @property text $data data
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class VehicleDispatchForm extends Model
{
    const HAS_PAYMENT_YES = 'Yes';

    const HAS_PAYMENT_NO = 'No';

    const CATEGORY_REVENUE = 'Revenue';

    const CATEGORY_EXPENSE = 'Expense';

    const CATEGORY_OTHERS = 'Others';

    const TYPE_FUEL = 'Fuel';

    const TYPE_CARRIAGE = 'Carriage';

    const TYPE_EXPENSE = 'Expense';

    const TYPE_FEEDING = 'Feeding';

    const TYPE_REPAIR = 'Repair';

    const TYPE_DISPATCH = 'Dispatch';

    const TYPE_OTHERS = 'Others';

    /**
     * Database table name
     */
    protected $table = 'vehicle_dispatch_forms';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['memo_id',
        'vehicle_dispatch_id',
        'type',
        'category',
        'has_payment',
        'amount',
        'data'];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function saveStatement($type = 'expense', $amount = 0, $status = 1){
        try{
            $vehicle_dispatch_form_id = $this->id;
            $statement  = new VehicleStatement();
            $statement->vehicle_dispatch_form_id = $vehicle_dispatch_form_id;
            $statement->type = $type;
            $statement->amount = $amount;
            $statement->status = $status;
            $statement->save();
            return 0;
        }catch (\Exception $e){
            return 1;
        }
    }

    public function memo(){
        return $this->belongsTo(Memo::class, 'memo_id');
    }

    public function revenue(){
        $amount = 0;
        $data = json_decode($this->data);
        if($this->category == self::CATEGORY_OTHERS || $this->category == self::CATEGORY_REVENUE)
            return $data->cost;
        return null;
    }

    public function expense(){
        $data = json_decode($this->data);
        if($this->category == self::CATEGORY_OTHERS){
            return $data->amount;
        }
        if($this->category == self::CATEGORY_EXPENSE)
            return $data->amount;
        return null;
    }

}
