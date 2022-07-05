<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use function Spatie\Backup\Tasks\Backup\selectedFiles;

/**
 * @property varchar $title title
 * @property longtext $body body
 * @property bigint $raise_by raise by
 * @property bigint $raised_for raised for
 * @property datetime $date_raised date raised
 * @property text $copy copy
 * @property enum $status status
 * @property enum $read_status read status
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property RaisedFor $user belongsTo
 * @property mixed forms
 * @property mixed type
 */
class Memo extends Model
{
    use HasFactory, Notifiable;
    const STATUS_OPEN = 'open';

    const STATUS_ARCHIVED = 'archived';

    const STATUS_CLOSED = 'closed';

    const STATUS_COMPLETED = 'completed';
    const STATUS_DRAFT = 'draft';

    const READ_STATUS_COPIED = 'copied';
    const READ_STATUS_NOT_SEEN = 'not seen';
    const READ_STATUS_SEEN = 'seen';
    const READ_STATUS_READ = 'read';

    const TYPE_MEMO = 'Memo';
    const TYPE_FORM = 'Form';
    const TYPE_VEHICLE = 'Vehicle';

    const FORM_ADJUSTMENT_APPROVAL = 'Adjustment Approval';
    const FORM_AUTHORITY_TO_PAY = 'Authority To Pay';
    const FORM_CASH_ADVANCE = 'Cash Advance';
    const FORM_HOUSING_ALLOWANCE = 'Housing Allowance';
    const FORM_MEAL_ALLOWANCE = 'Meal Allowance';
    const FORM_OFF_DAYS_ALLOWANCE = 'Off Days Allowance';
    const FORM_RECHARGE_CARD = 'Recharge Card';
    const FORM_WEEKLY_ENTERTAINMENT = 'Weekly Entertainment';
    const FORM_DIESEL_REQUEST = 'Diesel Request';
    const FORM_DISPATCH_TRUCK = 'Dispatch Truck';
    const FORM_CARRIAGE_BILL = 'Carriage Bill';

//    public $incrementing = false;
    /**
     * Database table name
     */
    protected $table = 'memos';

    /**
     * Mass assignable columns
     */
    /*protected $fillable = ['title',
        'body',
        'raise_by',
        'raised_for',
        'date_raised',
        'copy',
        'status'];*/

    protected $guarded = [];

    /**
     * Date time columns.
     */
    protected $dates = ['date_raised'];

	protected $casts = [
//		'created_at' => 'datetime:Y-m-Y h:i:s',
//		'updated_at' => 'datetime:Y-m-Y h:i:s'
	];
    /**
     * raisedFor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function raisedFor()
    {
        return $this->belongsTo(User::class, 'raised_for');
    }

    /**
     * raiseBy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function raisedBy()
    {
        return $this->belongsTo(User::class, 'raise_by');
    }

    public function currentLocation()
    {

    }

    public function visibleTo()
    {

    }

    public function minute()
    {
        return $this->hasMany(Minute::class)->with('attachment')->orderBy('id', 'DESC');
    }

    public function attachment()
    {
        return $this->hasMany(Attachement::class, 'model_id')->where('type', '=', 'Memo');
    }

    public function minutes()
    {
        return Minute::where("memo_id", "=", $this->id)->orderBy('id', 'DESC')->get();
    }

    public function lastMinute()
    {
        $minutes = $this->minutes();
        return count($minutes) ? $minutes->first() : null;
    }

    public function lastMinuteFrom()
    {
        $lm = $this->lastMinute();
        if ($lm) {
            return User::find($lm->from_user);
        }
    }

    public function lastMinuteTo()
    {
        $lm = $this->lastMinute();
        if ($lm) {
            return User::find($lm->to_user);
        }
    }


    public function attachments()
    {
        $attachmentObj = Attachement::where('type', 'Memo')->where('model_id', $this->id)->first();
        if ($attachmentObj) {
            return json_decode($attachmentObj->attachment);
        }

        return null;
    }

    public function hasAttachment()
    {
        $att = Attachement::where('model_id', $this->id)->where('type', 'Memo')->first();
        if ($att)
            return true;
        return false;
    }

    /*public function readStatus(){
        $copy = $read = '';
        $rs = $this->read_status;

        if($rs == self::READ_STATUS_COPIED){
            $read = '<span class="badge badge-secondary" style="background: black;color:white;font-size: 16px;font-weight: bolder;">copied</span>';
        }
        if($rs == self::READ_STATUS_NOT_SEEN){
            $read = '<span class="badge badge-danger" style="background: red;color:white;font-size: 16px;font-weight: bolder;">new</span>';
        }
        if($rs == self::READ_STATUS_SEEN){
            $read = '<span class="badge badge-info" style="background: darkgreen;color:white;font-size: 16px;font-weight: bolder;">seen</span>';
        }
        if($rs == self::READ_STATUS_READ){
            $read = '<span class="badge badge-success" style="background: yellow;color:black;font-size: 16px;font-weight: bolder;">read</span>';
        }
        if($this->copy != '' && $this->raise_by != auth()->id() && $this->raised_for != auth()->id()){
            $copy = explode(',', $this->copy);
            if (in_array(auth()->id(), $copy)) {
                $read = '<span class="badge badge-secondary" style="background: black;color:white;font-size: 16px;font-weight: bolder;">copied</span>';
            }
        }

        return $read;
    }*/

    public function readStatus()
    {
        $id = auth()->id();
        $copy = $status = '';
        $memoStatus = Minute::where(['memo_id' => $this->id])->latest()->first();
        if ($memoStatus) {
            if ($memoStatus->from_user == $id && $memoStatus->status == MemoStatus::STATUS_NOT_SEEN) {
                $status = '<span class="badge" style="background: darkgreen;color:white;font-size: 14px;font-weight: bolder;">Sent</span>';
            }
            if ($memoStatus->from_user != $id && $memoStatus->status == MemoStatus::STATUS_NOT_SEEN) {
                $status = '<span class="badge" style="background: red;color:white;font-size: 14px;font-weight: bolder;">new</span>';
            }
            if ($memoStatus->from_user == $id && $memoStatus->status == MemoStatus::STATUS_SEEN) {
                $status = '<span class="badge" style="background: #030065;color:white;font-size: 14px;font-weight: bolder;">Seen</span>';
            }
            if ($memoStatus->from_user != $id && $memoStatus->status == MemoStatus::STATUS_SEEN) {
                $status = '<span class="badge" style="background: red;color:white;font-size: 14px;font-weight: bolder;">new</span>';
            }
            if ($memoStatus->status == Minute::STATUS_READ) {
                $status = '<span class="badge" style="background: yellow;color:black;font-size: 14px;font-weight: bolder;">read</span>';
            }
            if ($memoStatus->from_user != $id && $memoStatus->to_user != $id) {
                $exist = Minute::whereRaw("(from_user = '$id' OR to_user = '$id') AND memo_id = $this->id ")->count();
                $existNotRead = Minute::whereRaw("(from_user = '$id' OR to_user = '$id') AND memo_id = $this->id AND status != 'read'")->count();
                if ($exist > 0 && $existNotRead == 0) {
                    $status = '<span class="badge" style="background: yellow;color:black;font-size: 14px;font-weight: bolder;">read</span>';
                } elseif ($this->copy != '' && $this->raise_by != $id && $this->raised_for != $id) {
                    $copy = explode(',', $this->copy);
                    if (in_array($id, $copy)) {
                        $status = '<span class="badge badge-secondary" style="background: black;color:white;font-size: 14px;font-weight: bolder;">copied</span>';
                    }
                } else {
                    $status = '<span class="badge" style="background: yellow;color:black;font-size: 14px;font-weight: bolder;">read</span>';
                }
            }
        } else {
            if($this->read_status != 'read') {
                if($this->raised_for == $id){
                    $status = '<span class="badge" style="background: red;color:white;font-size: 14px;font-weight: bolder;">new</span>';
                }else{
                    $status = '<span class="badge " style="background: yellow;color:black;font-size: 16px;font-weight: bolder;">read</span>';
                }
            }else{
                $status = '<span class="badge " style="background: yellow;color:black;font-size: 16px;font-weight: bolder;">read</span>';
            }
        }
        return $status;
    }

    public static function newReference()
    {
        $user = optional(auth())->user();
        $code = $user->referenceCode();
        $lastRecord = self::where('raise_by', $user->id)->where('reference', '!=', "")->orderBy('id', 'desc')->first();
        if (!$lastRecord)
            return $code . '/00001';
        $num = substr($lastRecord->reference, (strlen($code) + 1), 5);
        $new = $code . '/' .
            str_pad(
                (int)(intval($num) + 1),
                5, 0, STR_PAD_LEFT);

        return $new;
    }


    public function paymentProcess()
    {
        return PaymentProcess::where('memo_id', $this->id);
    }

    public function saveForms($request, $form)
    {
        $memo_id = $this->id;
        $type = $request->title;
        $data = json_encode($form);
        $accept_retirements = Form::ACCEPT_RETIREMENTS_NO;
        $has_payment = Form::HAS_PAYMENT_YES;
        if ($type == self::FORM_CASH_ADVANCE)
            $accept_retirements = Form::ACCEPT_RETIREMENTS_YES;

        $forms = new Form();
        $forms->id = newId();
        $forms->type = $type;
        $forms->memo_id = $memo_id;
        $forms->data = $data;
        $forms->accept_retirements = $accept_retirements;
        $forms->has_payments = $has_payment;
        if ($forms->save())
            return true;
        return false;
    }

    public function saveVehicleDispatches($request){
        $memo_id = $this->id;
        $now = now()->toDateTimeString();
        $vehicle_driver_id = $request->vehicle_driver_id;
        $status = VehicleDispatch::STATUS_OPENED;
        $number = VehicleDispatch::generateNewNumber();
        $last = VehicleDispatch::where(['vehicle_driver_id'=>$vehicle_driver_id,'date_to'=>null])->orderBy('id','desc')->first();
        if($last){
            $last->date_to = $now;
            $last->status = VehicleDispatch::STATUS_CLOSED;
            $last->save();
        }
        $dispatch = new VehicleDispatch();
        $dispatch->number = $number;
        $dispatch->memo_id = $memo_id;
        $dispatch->vehicle_driver_id = $vehicle_driver_id;
        $dispatch->date_from = $now;
        $dispatch->date_to = null;
        $dispatch->status = $status;
        if($dispatch->save()) return true;
        return false;
    }

    public function saveVehicleDispatchForms($request, $form = null){
        $memo_id = $this->id;
        $vehicle = Vehicle::find($request->vehicle_id);
        $dispatch = $vehicle->activeDispatch();
        $type = $request->form_type;
        $category = $request->form_category;
        $amount = null;
        $data = json_encode($form);
        $has_payment = VehicleDispatchForm::HAS_PAYMENT_NO;
        if($category != VehicleDispatchForm::CATEGORY_OTHERS) {
            $has_payment = VehicleDispatchForm::HAS_PAYMENT_YES;
            $amount = $request->amount;
        }
        $vehicleDispatchForm = new VehicleDispatchForm();
        $vehicleDispatchForm->memo_id = $memo_id;
        $vehicleDispatchForm->vehicle_dispatch_id = $dispatch->id;
        $vehicleDispatchForm->type = $type;
        $vehicleDispatchForm->data = $data;
        $vehicleDispatchForm->category = $category;
        $vehicleDispatchForm->has_payment = $has_payment;
        $vehicleDispatchForm->amount = $amount;
        if($vehicleDispatchForm->save()){
            $vehicleDispatchForm->saveStatement('revenue', $request->type,'');
            return true;
        }
        return false;
    }

    public function saveVehicleForms($request, $form = null){
        $memo_id = $this->id;
        $vehicle = Vehicle::find($request->vehicle_id);
        $vehicle_dispatch_id = $vehicle->activeDriver()?->id;
        $type = $request->form_type;
        $category = $request->form_category;
        $amount = null;
        $data = json_encode($form);
        $has_payment = VehicleDispatchForm::HAS_PAYMENT_NO;
        if($category != VehicleDispatchForm::CATEGORY_OTHERS) {
            $has_payment = VehicleDispatchForm::HAS_PAYMENT_YES;
            $amount = $request->amount;
        }
        $vehicleDispatchForm = new VehicleDispatchForm();
        $vehicleDispatchForm->memo_id = $memo_id;
        $vehicleDispatchForm->vehicle_dispatch_id = $vehicle_dispatch_id;
        $vehicleDispatchForm->type = $type;
        $vehicleDispatchForm->data = $data;
        $vehicleDispatchForm->category = $category;
        $vehicleDispatchForm->has_payment = $has_payment;
        $vehicleDispatchForm->amount = $amount;
        if($vehicleDispatchForm->save())
            return true;
        return false;
    }

    public function maintenanceForm($request){
        $memo_id = $this->id;
        $vehicle = Vehicle::find($request->vehicle_id);
        $maintenance = new VehicleMaintenance();
        $maintenance->reference = VehicleMaintenance::generateNewNumber();
        $maintenance->memo_id = $memo_id;
        $maintenance->vehicle_id = $request->vehicle_id;
        $maintenance->type = $request->maintenance_type;
        $maintenance->description = $request->description;
        $maintenance->amount = $request->amount;
        if($maintenance->save())
            return true;
        return false;
    }

    public function isForm()
    {
        if ($this->type == self::TYPE_FORM)
            return true;
        return false;
    }

    public function forms()
    {
        if ($this->isForm()) {
            return $this->hasOne(Form::class, 'memo_id');
        }
        return false;
    }

    public function formData()
    {
        if ($this->isForm()) {
            return json_decode($this->forms->data);
        }
        return false;
    }

    public function acceptRetirement(){
        if ($this->isForm())
            if ($this->forms->accept_retirements == Form::ACCEPT_RETIREMENTS_YES)
                return true;
        return false;
    }

    public function retirementStatus()
    {
        if ($this->isForm())
            if ($this->forms->accept_retirements == Form::ACCEPT_RETIREMENTS_YES)
                if (isset(json_decode($this->forms->data)->retirements)){
                    return '<span class="badge badge-success">Retired</span>';
                }else{
                    return '<span class="badge badge-danger">Not Retired</span>';
                }
    }

    public function hasRetired()
    {
        if ($this->isForm())
            if ($this->forms->accept_retirements == Form::ACCEPT_RETIREMENTS_YES)
                if (isset(json_decode($this->forms->data)->retirements))
                    return true;
                return false;
    }

    public function retirementTotalAmount(){
        if ($this->isForm()) {
            if ($this->forms->accept_retirements == Form::ACCEPT_RETIREMENTS_YES)
                $formData = json_decode($this->forms->data);
                if (isset($formData->retirements)){
                    $amount = 0;
                    for ($i = 0; $i < count($formData->retirements); $i++) {
                        $amount += $formData->retirements[$i];
                    }
                    return $amount;
                }
        }
        return false;
    }

    public function formsTotalAmount()
    {
        if ($this->isForm()) {
            $form = $this->forms()->where('has_payments', Form::HAS_PAYMENT_YES)->first();
            $formData = json_decode($form->data);
            $amount = 0;
            switch ($form->type) {
                case self::FORM_AUTHORITY_TO_PAY:
                    return $formData->amount;
                case self::FORM_CASH_ADVANCE:
                    for ($i = 0; $i < count($formData->particulars); $i++) {
                        $amount += $formData->amount[$i];
                    }
                    return $amount;
                case self::FORM_HOUSING_ALLOWANCE:
                    return $amount;
                case self::FORM_MEAL_ALLOWANCE:
                    for ($i = 0; $i < count($formData->amount); $i++) {
                        $amount += $formData->amount[$i];
                    }
                    return $amount;
            }

        }
        return false;
    }

    public function myFormsAmount($id)
    {
        $user = User::find($id);
        $userMemos = $user->memos();
        return $userMemos;
    }


    public function kiv(){
        $user = auth()->id();
        $kiv = MemoKiv::where(['user_id'=>$user, 'memo_id'=>$this->id])->first();
        if($kiv) return true;
        return false;
    }

    public function hasPaymentApproval(){
        $approval = MemoApproval::where(['memo_id'=>$this->id, 'approval'=> 'Payment'])->first();
        if($approval) return true;
        return false;
    }

    public function isApproved(){
        $approval = MemoApproval::where('memo_id', $this->id)->first();
        if($approval)
            if($approval->approved_by != null)
                return true;
        return false;
    }
    public function isVerified(){
        $approval = MemoApproval::where('memo_id', $this->id)->first();
        if($approval)
            if($approval->verified_by != null)
                return true;
        return false;
    }
    public function isAuthorized(){
        $approval = MemoApproval::where('memo_id', $this->id)->first();
        if($approval)
            if($approval->authorized_by != null)
                return true;
        return false;
    }
    public function isChecked(){
        $approval = MemoApproval::where('memo_id', $this->id)->first();
        if($approval)
            if($approval->checked_by != null)
                return true;
        return false;
    }

    public function getStatus(){
        if($this->isApproved())
            return "<span class='badge badge-success bg-gradient-success'>Approved</span>";
        if($this->isVerified())
            return "<span class='badge badge-warning bg-gradient-warning'>Verified</span>";
        if($this->isChecked())
            return "<span class='badge badge-primary bg-gradient-primary'>Checked</span>";
        if($this->isAuthorized())
            return "<span class='badge badge-secondary bg-gradient-secondary'>Authorized</span>";
        return "<span class='badge badge-danger bg-gradient-danger'>Pending</span>";
    }

    public function approval(){
        return $this->hasOne(MemoApproval::class, 'memo_id');
    }

}
