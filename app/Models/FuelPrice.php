<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property decimal $price price
 * @property varchar $term term
 * @property timestamp $date_from date from
 * @property timestamp $date_to date to
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class FuelPrice extends Model
{

    /**
     * Database table name
     */
    protected $table = 'fuel_prices';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name',
        'price',
        'term',
        'date_from',
        'date_to'];

    /**
     * Date time columns.
     */
    protected $dates = ['date_from',
        'date_to'];

    public function closed(){
        if($this->date_to != null) return true;
        return false;
    }

    public function status(){
        if($this->date_to != null) return '<span class="badge badge-danger">Closed</span>';
        return '<span class="badge badge-success">Active</span>';
    }
}
