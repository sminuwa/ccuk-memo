<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property enum $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at

 */
class InventoryCategory extends Model
{
    const STATUS_ACTIVE='active';

const STATUS_INACTIVE='inactive';

    /**
    * Database table name
    */
    protected $table = 'inventory_categories';

    /**
    * Mass assignable columns
    */
    protected $fillable=['name',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];



    public function items(){
        return $this->hasMany(InventoryItem::class,'category_id');
    }

}
