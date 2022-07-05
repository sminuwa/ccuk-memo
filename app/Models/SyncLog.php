<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property text $modals modals
 * @property timestamp $start_date start date
 * @property timestamp $end_date end date
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class SyncLog extends Model
{

    const DIRECTION_LTR = 'LTR'; // Local to Remote
    const DIRECTION_RTL = 'RTL'; // Remote to Local
    /**
     * Database table name
     */
    protected $table = 'sync_logs';

//    public $incrementing = false;
    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['modals',
        'start_date',
        'end_date'];*/
    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = ['start_date',
        'end_date'];


    public static function model($model)
    {
        $mdl = "";
        $MODEL = get_class($model);
        switch ($MODEL){
            case AccountCode::class: $mdl = "AccountCode"; break;
            case ActivityLog::class: $mdl = "ActivityLog"; break;
            case Attachement::class: $mdl = "Attachement"; break;
            case BankSupplier::class: $mdl = "BankSupplier"; break;
            case Branch::class: $mdl = "Branch"; break;
            case CashBook::class: $mdl = "CashBook"; break;
            case Department::class: $mdl = "Department"; break;
            case Form::class: $mdl = "Form"; break;
            case FormParticular::class: $mdl = "FormParticular"; break;
            case Group::class: $mdl = "Group"; break;
            case GroupMember::class: $mdl = "GroupMember"; break;
            case Memo::class: $mdl = "Memo"; break;
            case MemoDraft::class: $mdl = "MemoDraft"; break;
            case MemoStatus::class: $mdl = "MemoStatus"; break;
            case Message::class: $mdl = "Message"; break;
            case Minute::class: $mdl = "Minute"; break;
            case Newsfeed::class: $mdl = "Newsfeed"; break;
            case PaymentProcess::class: $mdl = "PaymentProcess"; break;
            case Permission::class: $mdl = "Permission"; break;
            case PermissionRole::class: $mdl = "PermissionRole"; break;
            case PermissionUser::class: $mdl = "PermissionUser"; break;
            case Position::class: $mdl = "Position"; break;
            case Role::class: $mdl = "Role"; break;
            case RoleUser::class: $mdl = "RoleUser"; break;
            case StaffPosition::class: $mdl = "StaffPosition"; break;
            case User::class: $mdl = "User"; break;
            case UserDetail::class: $mdl = "UserDetail"; break;
        }
        return $mdl;
    }

}
