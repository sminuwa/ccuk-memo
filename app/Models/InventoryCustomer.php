<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $code code
 * @property varchar $name name
 * @property varchar $phone phone
 * @property varchar $email email
 * @property varchar $address address
 * @property enum $status status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class InventoryCustomer extends Model
{
    const STATUS_ACTIVE = 'active';

    const STATUS_INACTIVE = 'inactive';

    /**
     * Database table name
     */
    protected $table = 'inventory_customers';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['code',
        'name',
        'phone',
        'email',
        'address',
        'status'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    public static function getNewCode(){
        $last = self::orderBy('id', 'desc')->first();
        if(!$last)
            return str_pad('1',5, 0, STR_PAD_LEFT);
        return str_pad(($last->code + 1),  5, 0, STR_PAD_LEFT);
    }

}
