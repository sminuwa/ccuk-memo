<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property varchar $code code
@property varchar $description description
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class CashBook extends Model 
{
    public $incrementing = false;
    /**
    * Database table name
    */
    protected $table = 'cash_books';

    /**
    * Mass assignable columns
    */
    /*protected $fillable=['name',
'code',
'description'];*/
    protected $guarded = [];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
