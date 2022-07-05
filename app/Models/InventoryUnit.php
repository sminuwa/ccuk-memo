<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property varchar $code code
 * @property enum $base_unit base unit
 * @property enum $operator operator
 * @property varchar $operation_value operation value
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class InventoryUnit extends Model
{
    const OPERATOR_MULTIPLY = 'Multiply';

    const OPERATOR_DIVIDE = 'Divide';

    const OPERATOR_PLUS = 'Plus';

    const OPERATOR_MINUS = 'Minus';

    const OPERATOR_ = '';

    const BASE_UNIT_METRE = 'Metre';

    const BASE_UNIT_PIECE = 'Piece';

    const BASE_UNIT_KILOGRAM = 'Kilogram';

    const BASE_UNIT_ = '';

    /**
     * Database table name
     */
    protected $table = 'inventory_units';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name',
        'code',
        'base_unit',
        'operator',
        'operation_value'];

    /**
     * Date time columns.
     */
    protected $dates = [];


    public function formula()
    {
        $operator = $result = "";
        if ($this->operator == 'Multiply') $operator = "*";

        if ($this->base_unit != null)
            return $this->base_unit . " (" . $this->getUnit($this->base_unit)->code . ") " . $operator . " " . $this->operation_value . "  = " . $this->name . " (" . $this->code . ")";
    }

    public function getUnit($name)
    {
        return self::where('name', $name)->first();
    }
}
