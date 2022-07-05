<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $user_id user id
@property bigint $memo_id memo id
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class MemoKiv extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'memo_kivs';

    /**
    * Mass assignable columns
    */
    protected $fillable=['user_id',
'memo_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}