<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $code code
 * @property varchar $name name
 * @property bigint $category_id category id
 * @property bigint $branch_id branch id
 * @property varchar $brand brand
 * @property varchar $unit unit
 * @property int $quantity quantity
 * @property int $alert_quantity alert quantity
 * @property int $unit_price unit price
 * @property varchar $picture picture
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class InventoryItem extends Model
{
    const STATUS_ACTIVE = 'active';

    const STATUS_INACTIVE = 'inactive';

    /**
     * Database table name
     */
    protected $table = 'inventory_items';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['code',
        'name',
        'category_id',
        'branch_id',
        'brand',
        'unit',
        'quantity',
        'alert_quantity',
        'unit_price',
        'picture',
        'status'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public static function getCode()
    {
        $last = self::orderBy('id', 'desc')->first();
        if(!$last)
            return '100001';
        return ($last->code + 1);
    }
}
