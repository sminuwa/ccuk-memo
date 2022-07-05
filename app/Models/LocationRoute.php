<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $location_from location from
@property bigint $location_to location to
@property bigint $route_id route id
@property varchar $distance distance
@property timestamp $created_at created at
@property timestamp $updated_at updated at

 */
class LocationRoute extends Model
{

    /**
    * Database table name
    */
    protected $table = 'location_routes';

    /**
    * Mass assignable columns
    */
    protected $fillable=['location_from',
'location_to',
'route_id',
'distance'];

    /**
    * Date time columns.
    */
    protected $dates=[];



    public function locationFrom(){
        return $this->belongsTo(Location::class, 'location_from');
    }

    public function locationTo(){
        return $this->belongsTo(Location::class, 'location_to');
    }

    public function route(){
        return $this->belongsTo(Route::class, 'route_id');
    }


}
