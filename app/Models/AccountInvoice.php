<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $reference reference
@property bigint $site site
@property bigint $payee payee
@property date $date date
@property varchar $gcca gcca
@property varchar $method method
@property decimal $amount amount
@property varchar $account account
@property varchar $currency currency
@property bigint $user user
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class AccountInvoice extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'account_invoices';

    /**
    * Mass assignable columns
    */
    protected $fillable=['reference',
'site',
'payee',
'date',
'gcca',
'method',
'amount',
'account',
'currency',
'user'];

    /**
    * Date time columns.
    */
    protected $dates=['date'];




}