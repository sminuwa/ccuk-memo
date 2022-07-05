<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $staffPosition hasMany

 */
class Position extends Model
{

    /**
    * Database table name
    */
    protected $table = 'positions';

//    public $incrementing = false;
    /**
    * Mass assignable columns
    */
    /*protected $fillable=['name','code'];*/
    protected $guarded = [];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * staffPositions
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function staffPositions()
    {
        return $this->hasMany(StaffPosition::class,'position_id');
    }

    public function hasMembers()
    {
        return count($this->staffPositions()->get());
    }

}
