<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $item_id item id
 * @property int $quantity quantity
 * @property int $unit_price unit price
 * @property date $date date
 * @property date $expiry expiry
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class InventoryPurchase extends Model
{

    /**
     * Database table name
     */
    protected $table = 'inventory_purchases';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['item_id',
        'quantity',
        'unit_price',
        'date',
        'expiry'];

    /**
     * Date time columns.
     */
    protected $dates = ['date', 'expiry'];


    public function item(){
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
