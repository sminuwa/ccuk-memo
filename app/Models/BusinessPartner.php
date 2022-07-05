<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property varchar $account_number account number
@property decimal $account_limit account limit
@property varchar $address address
@property enum $type type
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class BusinessPartner extends Model 
{
    const TYPE_CUSTOMER='customer';

const TYPE_SUPPLIER='supplier';

const TYPE_STAFF='staff';

    /**
    * Database table name
    */
    protected $table = 'business_partners';

    /**
    * Mass assignable columns
    */
    protected $fillable=['name',
'account_number',
'account_limit',
'address',
'type'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}