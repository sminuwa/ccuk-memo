<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bigint $model_id model id
 * @property varchar $model_name model name
 * @property varchar $reference reference
 * @property varchar $account account
 * @property enum $type type
 * @property decimal $amount amount
 * @property varchar $description description
 * @property varchar $code code
 * @property varchar $status status
 * @property date $date date
 * @property bigint $user_id user id
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Transaction extends Model
{
    const TYPE_CREDIT = 'Credit';

    const TYPE_DEBIT = 'Debit';

    /**
     * Database table name
     */
    protected $table = 'transactions';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['model_id',
        'model_name',
        'reference',
        'account',
        'type',
        'amount',
        'description',
        'code',
        'status',
        'date',
        'user_id'];

    /**
     * Date time columns.
     */
    protected $dates = ['date'];


    public function referenceModel(){
        $referenceModel = $this->reference_model;
        $referenceId = $this->reference_id;
        $Model = "\App\Models\\".$referenceModel;
        $model = $Model::find($referenceId);
        return $model;
    }

}
