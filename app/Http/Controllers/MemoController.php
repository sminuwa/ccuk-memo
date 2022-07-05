<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use App\Models\AttachmentUrl;
use App\Models\Department;
use App\Models\Form;
use App\Models\GroupMember;
use App\Models\MemoApproval;
use App\Models\MemoDraft;
use App\Models\MemoKiv;
use App\Models\MemoStatus;
use App\Models\Minute;
use App\Models\PaymentProcess;
use App\Models\UserDetail;
use App\Models\Vehicle;
use App\Models\VehicleDispatch;
use App\Models\VehicleDriver;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


/**
 * Description of MemoController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class MemoController extends Controller
{

	public function __construct() {
		$this->middleware(["auth"]);
	}

    public function interval(){
        return "1 MONTH";
    }

	public function index(Request $request) {
        $user = auth()->id();
        $interval = $this->interval();
        $newMemos = $this->newMemoFunc();
        $newReceived = $this->receivedMemoFunc();
        $allMemos = $this->allMemoFunc();
        $records = Memo::whereRaw("(memos.raise_by=$user OR memos.raised_for=$user OR FIND_IN_SET('$user',memos.copy) > 0 OR $user IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE()) AND memos.status = 'open' ORDER BY updated_at DESC")->get();

        DB::table("minutes")->where(['to_user'=>$user, 'status'=>Minute::STATUS_NOT_SEEN])->update(['status'=>'seen']);

        $status = "received";
        switch ($request->type){
            case 'ajax': return view('pages.memos.ajax', compact('records', 'allMemos','newMemos', 'newReceived'));
            default: return view('pages.memos.index', compact('records', 'allMemos','newMemos', 'newReceived', 'status'));
        }
	}

    public function newMemos(Request $request) {
        $user = auth()->id();
        $interval = $this->interval();
        $newMemos = $this->newMemoFunc();
        $newReceived = $this->receivedMemoFunc();
        $allMemos = $this->allMemoFunc();
        $records = Memo::whereRaw("(memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' AND read_status != 'read' AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE())")->orderBy('memos.id', 'desc')->get();

        DB::table("minutes")->where(['to_user'=>$user, 'status'=>Minute::STATUS_NOT_SEEN])->update(['status'=>'seen']);
        switch ($request->type){
            case 'ajax': return view('pages.memos.ajax', compact('records', 'allMemos','newMemos', 'newReceived'));
            default: return view('pages.memos.new', compact('records', 'allMemos','newMemos', 'newReceived'));
        }
    }

    public function sentMemos(Request $request) {
        $user = auth()->id();
        $interval = $this->interval();
        $newMemos = $this->newMemoFunc();
        $newReceived = $this->receivedMemoFunc();
        $allMemos = $this->allMemoFunc();
        $records = Memo::whereRaw("(memos.raise_by=$user OR memos.raised_for=$user OR $user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id AND status != 'read')) AND memos.status = 'open' AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE()) ORDER BY updated_at DESC")->get();

        DB::table("minutes")->where(['to_user'=>$user, 'status'=>Minute::STATUS_NOT_SEEN])->update(['status'=>'seen']);
        switch ($request->type){
            case 'ajax': return view('pages.memos.ajax', compact('records', 'allMemos','newMemos', 'newReceived'));
            default: return view('pages.memos.sent', compact('records', 'allMemos','newMemos', 'newReceived'));
        }
    }

    public function receivedMemos(Request $request) {
        $user = auth()->id();
        $interval = $this->interval();
        $newMemos = $this->newMemoFunc();
        $newReceived = $this->receivedMemoFunc();
        $allMemos = $this->allMemoFunc();
        $records = Memo::whereRaw("(($user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE() )) OR ((memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' AND read_status != 'read') AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE() ) ORDER BY updated_at DESC")
            ->get();

        DB::table("minutes")->where(['to_user'=>$user, 'status'=>Minute::STATUS_NOT_SEEN])->update(['status'=>'seen']);
        switch ($request->type){
            case 'ajax': return view('pages.memos.ajax', compact('records', 'allMemos','newMemos', 'newReceived'));
            default: return view('pages.memos.received', compact('records', 'allMemos','newMemos', 'newReceived'));
        }
    }

    public function currentMemos(Request $request) {
        $user = auth()->id();
        $interval = $this->interval();
        $newMemos = $this->newMemoFunc();
        $newReceived = $this->receivedMemoFunc();
        $allMemos = $this->allMemoFunc();
        $records = Memo::whereRaw("(($user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND memos.status = 'open') OR ((memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' AND read_status != 'read' AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE())) ORDER BY updated_at DESC")->get();

        DB::table("minutes")->where(['to_user'=>$user, 'status'=>Minute::STATUS_NOT_SEEN])->update(['status'=>'seen']);
        switch ($request->type){
            case 'ajax': return view('pages.memos.ajax', compact('records', 'allMemos','newMemos', 'newReceived'));
            default: return view('pages.memos.received', compact('records', 'allMemos','newMemos', 'newReceived'));
        }
    }

    public function newMemoFunc(){
        $user = auth()->id();
        $interval = $this->interval();
        return Memo::whereRaw("(memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' AND read_status != 'read' AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE()) ")->orderBy('memos.id', 'desc')->get()->count();
    }

    public function receivedMemoFunc(){
        $user = auth()->id();
        $interval = $this->interval();
        return Memo::whereRaw("(($user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id AND status != 'read')) AND memos.status = 'open') OR ((memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' AND read_status != 'read' AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE())) ORDER BY updated_at DESC")->get()->count();
    }

    public function allMemoFunc(){
        $user = auth()->id();
        $interval = $this->interval();
        return Memo::whereRaw("(memos.raise_by=$user OR memos.raised_for=$user OR FIND_IN_SET('$user',memos.copy) > 0 OR $user IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND memos.status = 'open' AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE())  ORDER BY updated_at DESC")->get()->count();
    }

    public function testMemos(Request $request){
        $user = auth()->id();
        $interval = $this->interval();
        $newMemos = $this->newMemoFunc();
        $newReceived = $this->receivedMemoFunc();
        $allMemos = $this->allMemoFunc();
        $records = Memo::whereRaw("(memos.raise_by=$user OR memos.raised_for=$user OR FIND_IN_SET('$user',memos.copy) > 0 OR $user IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND (created_at BETWEEN CURDATE() - INTERVAL $interval AND CURDATE()) AND memos.status = 'open' ORDER BY updated_at DESC")->get();

        DB::table("minutes")->where(['to_user'=>$user, 'status'=>Minute::STATUS_NOT_SEEN])->update(['status'=>'seen']);
        $status = "received";
        switch ($request->type){
            case 'ajax': return view('pages.memos.ajax', compact('records', 'allMemos','newMemos', 'newReceived'));
            default: return view('pages.memos.test', compact('records', 'allMemos','newMemos', 'newReceived', 'status'));
        }
    }

	public function show(Request $request, $memo_id) {
		$memo = Memo::find($memo_id);
		$user = auth()->user();
        $id = $user->id;
		DB::table("memos")->where(["raised_for" => $user->id, "id" => $memo_id])->update(["read_status" => "read"]);
		DB::table("minutes")->where(['to_user' => auth()->id(), 'memo_id' => $memo_id])->update(['status' => Minute::STATUS_READ]);
        $minutes = Minute::whereRaw("memo_id=$memo_id AND (to_user =$id OR from_user=$id)")->first();
        $copied = Memo::whereRaw("id=$memo_id AND (raise_by=$id OR raised_for=$id OR FIND_IN_SET('$id',copy))")->first();
        if((auth()->user()->canAccess('memos.general-access'))|| ($memo->raise_by == $user->id || $memo->raised_for == $user->id || $minutes || $copied))
		    return view('pages.memos.show', compact('memo'));
        return "You are not allowed to view this memo";

	}

	public function create(Request $request) {
		$users = User::all(['id']);
		$users = User::all(['id']);

		return view('pages.memos.create', [
			'model' => new Memo,
			"users" => $users,
			"users" => $users,

		]);
	}

	public function store(Request $request) {

        /*if($request->fuel_option)
            return $request;*/

//        return $this->vehicleDispatches($request)->body;
//        return json_encode($this->forms($request)->form);
		try {
			$user_id = auth()->id();
            $type = $request->type;
			if (!$request->draft) {
				$this->validate($request, [
					'sendto' => 'required',
					'title' => 'required',
				]);
			} else {
				$this->validate($request, [
					'title' => 'required',
					'body' => 'required'
				]);
				$draft = MemoDraft::find($request->draft_id);
				if (!$draft)
					$draft = new MemoDraft();
				$draft->id = newId();
				$draft->title = $request->title;
				$draft->body = $request->body;
				$draft->user_id = auth()->id();
				$draft->save();
				return back()->with(['message' => 'Memo saved as draft', 'draft-body' => $request->body, 'draft-title' => $request->title]);
			}
			$copyMail = $request->copy;
			if (!$copyMail) {
				$copy = '';
			} else {
				$cp = [];
				foreach ($copyMail as $c) {
					if (substr($c, 0, 1) == "p") {
						$cp = array_merge($cp, User::where("position_id", "=", substr($c, 1))->pluck('id')->toArray());
					} else if (substr($c, 0, 1) == "d") {
						$cp = array_merge($cp, UserDetail::where("department_id", "=", substr($c, 1))->pluck('user_id')->toArray());
					} else if (substr($c, 0, 1) == "g") {
						$cp = array_merge($cp, GroupMember::where("group_id", "=", substr($c, 1))->pluck('user_id')->toArray());
					} else {
						$cp[] = $c;
					}
				}
				$copy = implode(',', $cp);
			}
			$model = new Memo;
			$model->reference = Memo::newReference();
			$model->title = $request->title;
            switch($type){
                case Memo::TYPE_FORM:
                    if (!$copyMail) {
                        $copy = $this->forms($request)->copy;
                    } else {
                        $copy = $copy . ',' . $this->forms($request)->copy;
                    }
                    $model->body = $this->forms($request)->body;
                    $model->type = Memo::TYPE_FORM;
                    break;
                case Memo::TYPE_VEHICLE:
                    $model->body = "";
                    $model->type = Memo::TYPE_VEHICLE;
                    if($request->form_category != "Maintenance") {
                        $driver = User::find(VehicleDriver::find($request->vehicle_driver_id)->user_id);
                        $copy = $driver->id;
                    }else{

                    }
                    break;
                default:
                    $model->body = $request->body;
                    $model->type = Memo::TYPE_MEMO;
            }
			$model->raised_for = intval($request->sendto);
			$model->raise_by = $user_id;
			$model->copy = $copy;
			$model->date_raised = now()->toDateTimeString();
			if ($model->save()) {
                switch ($type){
                    case Memo::TYPE_FORM:
                        $model->saveForms($request, $this->forms($request)->form);
                        break;
                    case Memo::TYPE_VEHICLE:
                        if($request->form_category != "Maintenance") {
                            if ($request->is_dispatch) {
                                $model->saveVehicleDispatches($request);
                            }
                            $model->saveVehicleDispatchForms($request, $this->forms($request)->form);
                        }else{
                            $model->maintenanceForm($request);
                        }
                        break;
                    default:
                }
                /*
                 * saving memo statuses */
				$statuses = MemoStatus::where(['send_from' => $user_id, 'send_to' => $request->sendto, 'model_id' => $model->id, 'model' => 'Memo'])->first();
				if (!$statuses)
					$statuses = new MemoStatus();
				$statuses->send_from = $user_id;
				$statuses->send_to = $request->sendto;
				$statuses->status = MemoStatus::STATUS_NOT_SEEN;
				$statuses->model_id = $model->id;
				$statuses->model = "Memo";
				$statuses->save();
                /*
                 * checking if there is attachment on this memo*/
				if ($request->file()) {
					$attachment_name = $request->attachment_name;
					$attachment = $request->attachment;
					$attach = array();
					for ($i = 0; $i < count($attachment); $i++) {
						$fileName = time() . '_' . $attachment[$i]->getClientOriginalName();
                        if ($attachment[$i]->move(base_path('public/files'), $fileName)) {
							$attach[] = [
								"name" => 'files/' . $fileName,
								"usrName" => $attachment_name[$i],
								"size" => '',//$attachment[$i]->getMimeType(),
								"type" => '',//$attachment[$i]->getSize(),
								"thumbnail" => "",
								"thumbnail_type" => "",
								"thumbnail_size" => "",
								"searchStr" => ""
							];//$fileName;
						}
					}
					$att_model = new Attachement();
					$att_model->model_id = $model->id;
					$att_model->title = "";
					$att_model->attachment = json_encode($attach);
					$att_model->type = 'Memo';
					$att_model->save();
				}
				session()->flash('message', 'Memo sent successfully');
//                return $request;
				return redirect()->route('memos.show', $model->id);
			}
//            return $request;
			return back()->with('error', 'Something is wrong while sending Memo');

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function forms($request) {
		$subject = $request->title;
		$html = '';
		$form = array();
		$copy = '';
        $type = $request->type;
        if($type == Memo::TYPE_VEHICLE){
            $formType = $request->form_type;
            switch ($formType){
                case "Dispatch":
                    $form = $request->only(
                        'title',
                        'vehicle_id',
                        'vehicle_driver_id',
                        'type',
                        'form_type',
                        'form_category',
                        'is_dispatch',
                        'shipped_from',
                        'shipped_to',
                        'item',
                        'cost',
                        'has_commission',
                        'commission',
                        'fuel_option',
                        'filling_station',
                        'route',
                        'litre',
                        'amount_per_litre',
                        'amount',
                    );

                    break;
                case "Carriage": $form = $request->only(
                        'title',
                        'vehicle_id',
                        'vehicle_dispatch_id',
                        'vehicle_driver_id',
                        'type',
                        'form_type',
                        'form_category',
                        'shipped_from',
                        'shipped_to',
                        'item',
                        'cost',
                        'has_commission',
                        'commission',
                    );
                    break;
                case "Fuel": $form = $request->only(
                        'title',
                        'vehicle_id',
                        'vehicle_dispatch_id',
                        'vehicle_driver_id',
                        'type',
                        'form_type',
                        'form_category',
                        'fuel_option',
                        'filling_station',
                        'route',
                        'litre',
                        'amount_per_litre',
                        'amount',
                    );
                    break;
                case "Repair": $form = $request->only('vehicle_id', 'vehicle_driver_id');
            }

        }
		if ($subject == Memo::FORM_MEAL_ALLOWANCE) {
			$name = $request->name;
			$date = $request->date;
			$breakfast = $request->breakfast;
			$launch = $request->launch;
			$dinner = $request->dinner;
			$form = $request->only('name', 'date', 'breakfast', 'launch', 'dinner');
			$copy = implode(',', $name);
			$html .= '<table class="mt-lg-3 table table-bordered table-striped mt-lg-3" width="100%">';
			$html .= '<tr><th>#</th><th>Name</th><th>Department</th><th>Date</th><th>Breakfast</th><th>Launch</th><th>Dinner</th><th>Sub Total</th></tr>';
			$total = 0;
			for ($i = 0; $i < count($name); $i++) {
				$amount = ($breakfast[$i] + $launch[$i] + $dinner[$i]);
				$us = User::find($name[$i]);
				$n = $us->fullName();
				$department = $us->department()->name;
				$html .= "<tr>";
				$html .= '<td>' . ($i + 1) . '</td>';
				$html .= '<td>' . $n . '</td>';
				$html .= '<td>' . $department . '</td>';
				$html .= '<td>' . $date[$i] . '</td>';
				$html .= '<td>' . number_format($breakfast[$i]) . '</td>';
				$html .= '<td>' . number_format($launch[$i]) . '</td>';
				$html .= '<td>' . number_format($dinner[$i]) . '</td>';
				$html .= '<td>' . number_format($amount) . '</td>';
				$html .= "</tr>";
				$total += $amount;
			}
			$html .= '<tr><th colspan="7" class="text-right">Total</th><td>' . number_format($total) . '</td></tr>';
			$html .= '</table>';
		} elseif ($subject == Memo::FORM_AUTHORITY_TO_PAY) {
			$amount = $request->amount;
			$reason = $request->reason;
			if ($request->by == 'staff') {
				$name = $request->name;
				$form = $request->only('by', 'name', 'amount', 'reason');
				$copy = $name;
				$fullname = User::find($name)->fullName();
			} else {
				$department = $request->department;
				$form = $request->only('by', 'department', 'amount', 'reason');
				$copy = '';
				$fullname = Department::find($department)->name;
			}
			$html .= '<div class="mt-lg-3"><style> .pp{ border-bottom:1px solid #cccccc; padding:5px;}</style>';
			$html .= '<p class="pp">PLEASE PAY THE SUM OF: <strong>' . number_format($amount) . '</strong></p>';
			$html .= '<p class="pp">AMOUNT IN WORD: <strong>' . numberTowords($amount) . '</strong></p>';
			$html .= '<p class="pp">BENEFICIARY: <strong>' . $fullname . '</strong></p>';
			$html .= '<p class="pp">REASON FOR PAYMENT: <strong>' . $reason . '</strong></p>';
			$doc = "";
			if ($request->file()) {
				$doc = "Yes";
			}
			$html .= '<p class="pp">DOCUMENT (IF ANY): <strong>' . $doc . '</strong></p>';
			$html .= '</div>';
		} elseif ($subject == Memo::FORM_ADJUSTMENT_APPROVAL) {
			$on = $request->on;
			$document_number = $request->document_number;
			$document_type = $request->document_type;
			$document_date = $request->document_date;
			$reason = $request->reason;
			$form = $request->only('on', 'document_number', 'document_type', 'document_date', 'reason');
			$copy = auth()->id();
			$html .= '<div class="mt-lg-3"><style> .pp{ border-bottom:1px solid #cccccc; padding:5px;}</style>';
			$html .= '<p>Reason for <strong>' . $on . '</strong> adjustment</p>';
			$html .= '<p>This attached document is hereby forwarded for approval to make the necessary adjustment(s) to regularize the record.</strong></p>';
			$html .= '<p>DOCUMENT NO.: <strong>' . $document_number . '</strong><br>DOCUMENT TYPE: <strong>' . $document_type . '</strong><br>DOCUMENT DATE: <strong>' . $document_date . '</strong></p>';
			$html .= '<p>REASON FOR ADJUSTMENT/ACCOUNT AFFECTED: <br> <strong>' . $reason . '</strong></p>';
			$html .= '</div>';
		} elseif ($subject == Memo::FORM_CASH_ADVANCE) {
			$touring = $request->touring;
			$particulars = $request->particulars;
			$amount = $request->amount;
			if ($request->by == 'staff') {
				$name = $request->name;
				$form = $request->only('by', 'name', 'touring', 'particulars', 'amount');
				$copy = $name;
				$fullname = User::find($name)->fullName();
				$department = User::find($name)->department()->name;
			} else {
				$department = $request->department;
				$form = $request->only('by', 'department', 'touring', 'particulars', 'amount');
				$copy = 0;
				$dept = Department::find($department);
				$fullname = $department = $dept->name;
			}
			$total = 0;
			$html .= '<div class="mt-lg-3"><style>p{margin-bottom:.1rem;} .pp{ border-bottom:1px solid #cccccc; padding:2px;}</style>';
			$html .= '<p class="pp">NAME: <strong>' . $fullname . '</strong></p>';
			$html .= '<p class="pp">DEPARTMENT: <strong>' . $department . '</strong></p>';
			$html .= '<p class="pp">TOURING: <strong>' . $touring . '</strong></p>';
			$html .= '</div>';
			$html .= '<table class="mt-lg-3 table table-bordered table-striped" width="100%">';
			$html .= '<tr><th>#</th><th>Particular</th><th>Amount</th></tr>';
			for ($i = 0; $i < count($particulars); $i++) {
				$html .= "<tr>";
				$html .= '<td>' . ($i + 1) . '</td>';
				$html .= '<td>' . $particulars[$i] . '</td>';
				$html .= '<td>' . number_format($amount[$i]) . '</td>';
				$html .= "</tr>";
				$total += $amount[$i];
			}
			$html .= '<tr><td colspan="2" class="text-right">Total</td><td>' . number_format($total) . '</td>';
			$html .= '</table>';
		} elseif ($subject == Memo::FORM_HOUSING_ALLOWANCE) {
			$name = $request->name;
			$amount = $request->amount;
			$copy = $name;
			$form = $request->only('name', 'amount');
			$us = User::find($name);
			$html .= '<div class="mt-lg-3"><style> .pp{ border-bottom:1px solid #cccccc; padding:5px;line-height: 2.0;}</style>';
			$html .= '<p>I <strong class="pp">' . strtoupper($us->fullName()) . '</strong>
                      wish to apply for payment of my housing allowance (upfront) sum of <strong class="pp">' . number_format($amount) . '</strong></p>';
			$html .= '<p>I hope my application will be considered.</p>';
			$html .= '</div>';
		} elseif ($subject == Memo::FORM_RECHARGE_CARD) {
			$name = $request->name;
			$amount = $request->amount;
			$form = $request->only('name', 'amount');
			$copy = implode(',', $name);
			$h = '';
			$h .= '<table class="table table-bordered table-striped mt-lg-3" width="100%">';
			$h .= '<tr><th>#</th><th>Name</th><th>Department</th><th>Amount</th></tr>';
			$total = 0;
			for ($i = 0; $i < count($name); $i++) {
				$us = User::find($name[$i]);
				$n = $us->fullName();
				$department = $us->department()->name;
				$h .= "<tr>";
				$h .= '<td>' . ($i + 1) . '</td>';
				$h .= '<td>' . $n . '</td>';
				$h .= '<td>' . $department . '</td>';
				$h .= '<td>' . number_format($amount[$i]) . '</td>';
				$h .= "</tr>";
				$total += $amount[$i];
			}
			$html .= '<p class="mt-lg-2">Kindly approve the payment of <strong>' . numberTowords($total) . '</strong>, for the purchase of recharge card for the various Department to enable them carry out their duties efficiently and effectively </p>';
			$html .= $h;
			$html .= '<tr><th colspan="3" class="text-right">Total</th><td>' . number_format($total) . '</td></tr>';
			$html .= '</table>';
		} elseif ($subject == Memo::FORM_OFF_DAYS_ALLOWANCE) {
			$name = $request->name;
			$date = $request->date;
			$no_of_days = $request->no_of_days;
			$amount = $request->amount;
			$form = $request->only('name', 'date', 'no_of_days', 'amount');
			$copy = implode(',', $name);
			$html .= '<table class="table table-bordered table-striped mt-lg-3" width="100%">';
			$html .= '<tr><th>#</th><th>Name</th><th>Department</th><th>Date</th><th>No. of Days</th><th>Amount</th></tr>';
			$total = 0;
			for ($i = 0; $i < count($name); $i++) {
				$us = User::find($name[$i]);
				$n = $us->fullName();
				$department = $us->department()->name;
				$html .= "<tr>";
				$html .= '<td>' . ($i + 1) . '</td>';
				$html .= '<td>' . $n . '</td>';
				$html .= '<td>' . $department . '</td>';
				$html .= '<td>' . $date[$i] . '</td>';
				$html .= '<td>' . $no_of_days[$i] . '</td>';
				$html .= '<td>' . number_format($amount[$i]) . '</td>';
				$html .= "</tr>";
				$total += $amount[$i];
			}
			$html .= '<tr><th colspan="5" class="text-right">Total</th><td>' . $total . '</td></tr>';
			$html .= '</table>';
			$html .= '<p class="mt-lg-1">Kindly approve the sum of <strong>(' . number_format($total) . ') ' . numberTowords($total) . '</strong></p>';
		} elseif ($subject == Memo::FORM_WEEKLY_ENTERTAINMENT) {
			$item = $request->item;
			$quantity = $request->quantity;
			$unit_price = $request->price;
			$form = $request->only('item', 'quantity', 'price');
			$copy = auth()->id();
			$html .= '<table class="table table-bordered table-striped mt-lg-3" width="100%">';
			$html .= '<tr><th>#</th><th>Item Required</th><th>Quantity</th><th>Unit Price</th><th>Amount</th></tr>';
			$total = 0;
			for ($i = 0; $i < count($item); $i++) {
				$html .= "<tr>";
				$html .= '<td>' . ($i + 1) . '</td>';
				$html .= '<td>' . $item[$i] . '</td>';
				$html .= '<td>' . $quantity[$i] . '</td>';
				$html .= '<td>' . number_format($unit_price[$i]) . '</td>';
				$html .= '<td>' . number_format(($quantity[$i] * $unit_price[$i])) . '</td>';
				$html .= "</tr>";
				$total += ($quantity[$i] * $unit_price[$i]);
			}
			$html .= '<tr><th colspan="4" class="text-right">Total</th><td>' . number_format($total) . '</td></tr>';
			$html .= '</table>';
			$html .= '<p class="mt-lg-1">Amount in word: <strong style="text-decoration: underline;">' . numberTowords($total) . '</strong></p>';
		} elseif ($subject == Memo::FORM_DIESEL_REQUEST) {
			$destination = $request->destination;
			$litre_requested = $request->litre_requested;
			$litre_issued = $request->litre_issued;
			$amount = $request->amount;
			$vehicle_type = $request->vehicle_type;
			$vehicle_no = $request->vehicle_no;
			$filling_station = $request->filling_station;
			$form = $request->only('driver', 'destination', 'litre_requested', 'litre_issued', 'amount', 'vehicle_type', 'vehicle_no', 'officer', 'filling_station');
			$driver = User::find($request->driver);
			$officer = User::find($request->officer);
			$copy = $driver->id . ',' . $officer->id;
			$html .= '<table class="table table-bordered table-striped mt-lg-3" width="100%">';
			$html .= '<tr><th width="30%">Destination</th><td colspan="3">' . $destination . '</td></tr>';
			$html .= '<tr><th>Driver\'s Name</th><td colspan="3">' . $driver->fullName() . '</td></tr>';
			$html .= '<tr><th>Vehicle Type</th><td>' . $vehicle_type . '</td><th>Vehicle Number</th><td>' . $vehicle_no . '</td></tr>';
			$html .= '<tr><th>Litre Requested</th><td>' . $litre_requested . '</td><th>Litre Issued</th><td>' . $litre_issued . '</td></tr>';
			$html .= '<tr><th>Transport Officer</th><td colspan="3">' . $officer->fullName() . '</td></tr>';
			$html .= '<tr><th>Filling Station & Address</th><td colspan="3">' . $filling_station . '</td></tr>';
			$html .= '<tr><th colspan="3" class="text-right">Total</th><td>' . number_format($amount) . '</td></tr>';
			$html .= '</table>';
			$html .= '<p class="mt-lg-1">Amount in word: <strong style="text-decoration: underline;">' . numberTowords($amount) . '</strong></p>';
		}

		return json_decode(json_encode(array('body' => $html, 'form' => $form, 'copy' => $copy)));
	}

	public function storeRetirementForm(Request $request) {
		$memo_id = $request->memo_id;
		$amount = $request->amount;
		$memo = Memo::find($memo_id);
		$form = Form::where('memo_id', $memo_id)->first();
		$html = '';
		if ($form) {
			$data = json_decode($form->data, true);
			$dataObj = json_decode($form->data);
			$data['retirements'] = $amount;
			$form->data = json_encode($data);
			if ($form->save()) {
				$particulars = $dataObj->particulars;
				$amount = $dataObj->amount;
				$retirements = $dataObj->retirements;
				$us = User::find($dataObj->name);
				$total = 0;
				$totalRetired = 0;
				$html .= '<div class="mt-lg-3"><style>p{margin-bottom:.1rem;} .pp{ border-bottom:1px solid #cccccc; padding:2px;}</style>';
				$html .= '<p class="pp">NAME: <strong>' . $us->fullName() . '</strong></p>';
				$html .= '<p class="pp">DEPARTMENT: <strong>' . $us->department()->name . '</strong></p>';
				$html .= '<p class="pp">TOURING: <strong>' . $dataObj->touring . '</strong></p>';
				$html .= '</div>';
				$html .= '<table class="mt-lg-3 table table-bordered table-striped" width="100%">';
				$html .= '<tr><th>#</th><th>Particular</th><th>Amount Received</th><th>Amount Retired</th></tr>';
				for ($i = 0; $i < count($particulars); $i++) {
					$html .= "<tr>";
					$html .= '<td>' . ($i + 1) . '</td>';
					$html .= '<td>' . $particulars[$i] . '</td>';
					$html .= '<td>' . number_format($amount[$i]) . '</td>';
					$html .= '<td>' . number_format($retirements[$i]) . '</td>';
					$html .= "</tr>";
					$total += $amount[$i];
					$totalRetired += $retirements[$i];
				}
				$html .= '<tr><td colspan="2" class="text-right">Total</td><td>' . number_format($total) . '</td><td>' . number_format($totalRetired) . '</td></tr>';
				$html .= '</table>';
				$memo->body = $html;
				$memo->save();
			}
			if ($request->file()) {
				$attachment_name = $request->attachment_name;
				$attachment = $request->attachment;
				$attach = array();
				for ($i = 0; $i < count($attachment); $i++) {
					$fileName = time() . '_' . $attachment[$i]->getClientOriginalName();
					if ($attachment[$i]->move(base_path('public/files'), $fileName)) {
						$attach[] = [
							"name" => 'files/' . $fileName,
							"usrName" => $attachment_name[$i],
							"size" => '',//$attachment[$i]->getMimeType(),
							"type" => '',//$attachment[$i]->getSize(),
							"thumbnail" => "",
							"thumbnail_type" => "",
							"thumbnail_size" => "",
							"searchStr" => ""
						];//$fileName;
					}
				}
				$att_model = new Attachement();
				$att_model->id = newId();
				$att_model->model_id = $memo_id;
				$att_model->title = "";
				$att_model->attachment = json_encode($attach);
				$att_model->type = 'Memo';
				$att_model->save();
			}
			return back()->with('message', 'Retirement successfully updated');
		}
	}

	public function reportMemos(Request $request) {
		return $request;
	}

	public function edit(Request $request, Memo $memo) {
		$users = User::all(['id']);
		$users = User::all(['id']);

		return view('pages.memos.edit', [
			'model' => $memo,
			"users" => $users,
			"users" => $users,

		]);
	}

	public function update(Request $request, Memo $memo) {
		$memo->fill($request->all());

		if ($memo->save()) {

			session()->flash('app_message', 'Memo successfully updated');
			return redirect()->route('memos.index');
		} else {
			session()->flash('app_error', 'Something is wrong while updating Memo');
		}
		return redirect()->back();
	}

	public function destroy(Request $request, Memo $memo) {
		if ($memo->delete()) {
			session()->flash('app_message', 'Memo successfully deleted');
		} else {
			session()->flash('app_error', 'Error occurred while deleting Memo');
		}

		return redirect()->back();
	}

	public function memoPrint($id) {
		$memo = Memo::find($id);
		return view('pages.memos.print', compact('memo'));
	}

	public function ringing() {
		$user = auth()->id();
//        $user = 4;
		$last = Memo::whereRaw("memos.raise_by=$user OR memos.raised_for=$user OR FIND_IN_SET('$user',memos.copy) > 0 OR $user IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)")->orderBy('updated_at', 'desc')->first();
		if ($last)
			return $last->id;
		return 0;
	}

	public function archive(Memo $memo) {
        $this->middleware('permission:archived.close,archived.reopen');
		if ($memo->status == Memo::STATUS_OPEN) {
			$memo->status = Memo::STATUS_ARCHIVED;
			$memo->save();
			return back();
		}
		if ($memo->status == Memo::STATUS_ARCHIVED) {
			$memo->status = Memo::STATUS_OPEN;
			$memo->save();
			return back();
		}
	}

	public function archived() {
        $this->middleware('permission:archived.close,archived.reopen,archived.index');
		return view('pages.memos.archived'/*, ['records' => $records]*/);
	}

	public function deleteDraft(Request $request) {
		MemoDraft::find($request->draft_id)->delete();
		return true;
	}

	public function paymentProcess(Request $request) {
		try {
			$memo_id = $request->memo_id;
			$account_debited = $request->account_debited;
			$account_credited = $request->account_credited;
			$amount = $request->amount;
			$beneficiary_type = $request->beneficiary_type;
			$narration = $request->narration;
			$beneficiary = "";
			$payment = new PaymentProcess();
			$payment->id = newId();
			$payment->memo_id = $memo_id;
			$payment->account_debited = implode(',', $account_debited);
			$payment->account_credited = implode(',', $account_credited);
			$payment->amount = $amount;
			$payment->amount = $amount;
			$payment->beneficiary_type = $beneficiary_type;
			if ($request->beneficiary_type == 'Transfer') {
				$beneficiary = '<tr><td class="text-right" style="text-align: right;"><strong>Beneficiary Name:</strong></td>';
				$beneficiary .= '<td>' . $request->beneficiary_name . '</td></tr>';
				$beneficiary .= '<tr><td class="text-right" style="text-align: right;"><strong>Beneficiary Account:</strong></td>';
				$beneficiary .= '<td>' . $request->beneficiary_account . '</td></tr>';
				$beneficiary .= '<tr><td class="text-right" style="text-align: right;"><strong>Beneficiary Bank:</strong></td>';
				$beneficiary .= '<td>' . $request->beneficiary_bank . '</td></tr>';
			}
			if ($request->beneficiary_type == 'Cheque') {
				$beneficiary = '<tr><td class="text-right" style="text-align: right;"><strong>Beneficiary Name:</strong></td>';
				$beneficiary .= '<td>' . $request->beneficiary_name . '</td></tr>';
			}
			if ($request->beneficiary_type == 'Cash') {
				$beneficiary = '<tr><td class="text-right" style="text-align: right;"><strong>Beneficiary Name:</strong></td>';
				$beneficiary .= '<td>' . $request->beneficiary_name . '</td></tr>';
			}
			$payment->beneficiary = $beneficiary;
			$payment->narration = $narration;
			$payment->save();
			return back()->with('message', 'Payment processes has been sent');
		} catch (\Exception $e) {
			return back()->with('error', $e->getMessage());
		}
	}

	public function cancelPaymentProcess(Memo $memo) {
		try {
			if (PaymentProcess::where('memo_id', $memo->id)->delete())
				return back()->with('message', 'Payment Cancelled');
			return back()->with('error', 'Something went wrong');
		} catch (\Exception $e) {
			return back()->with('error', $e->getMessage());
		}
	}

	public function all() {
		return view('pages.memos.all');
	}

	public function memoFilter() {
		return view('pages.memos.filter');
	}

	public function memoFilterSearch(Request $request) {
		try {
			$from = $request->date_from;
			$to = $request->date_to;
			$search = $request->search;;
			$filter = $request->filter;
			$qry = "";
			switch ($filter) {
				case "by_sender":
					$pre_qry = implode(', ', DB::table('user_details')->whereRaw("surname like '%$search%' OR first_name like '%$search%' OR other_names like '%$search%' ")->pluck('id')->toArray());
					$qry = 'memos.raise_by IN (' . $pre_qry . ')';
					break;
				case "by_receiver":
					$pre_qry = implode(', ', DB::table('user_details')->whereRaw("surname like '%$search%' OR first_name like '%$search%' OR other_names like '%$search%' ")->pluck('id')->toArray());
					$qry = 'memos.raised_for IN (' . $pre_qry . ')';
					break;
				case "by_reference":
					$qry = "memos.reference like '%$search%' ";
					break;
				case "by_memo":
					$qry = "memos.body like '%$search%' ";
					break;
				case "by_minute":
					$pre_qry = implode(', ', DB::table('user_details')->whereRaw("surname like '%$search%' OR first_name like '%$search%' OR other_names like '%$search%' ")->pluck('id')->toArray());
					$pre_qry1 = implode(', ', DB::table('minutes')->whereRaw("to_user IN ('$pre_qry') ")->pluck('memo_id')->toArray());
                    $qry = "memos.id IN ($pre_qry1)";
                    /*if(is_null($pre_qry1)){
                    }*/
//                    return  $qry;
					break;
				default: $qry = "0";
			}
			if(!$to)
				$to = now()->toDateTimeString();
			if($from){
				$qry = "(memos.created_at between '$from' AND '$to') AND " . $qry;
			}

            $user = auth()->user();
            $id = auth()->id();
            if($user->canAccess('memos.filter.index')){
                $user_qry = "";
            }else{
                $user_qry = "(memos.raise_by=$id OR memos.raised_for=$id OR FIND_IN_SET('$id',memos.copy) > 0 OR $id IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $id IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND";
            }
			$memos = Memo::whereRaw("$user_qry $qry")->orderBy('created_at', 'desc')->get();
//            return $memos;
			/*$html = '';
			$index = 1;
			foreach ($memos as $memo) {
				$sender = $receiver = "Me";
				if ($memo->raisedBy->id != auth()->id()) {
					$sender = "<a href='" . route("memos.show", $memo->id) . "'>" . $memo->raisedBy->fullName() . "</a>";
				}
				if ($memo->raisedFor->id != auth()->id()) {
					$receiver = "<a href='" . route("memos.show", $memo->id) . "'>" . $memo->raisedFor->fullName() . "</a>";
				}
//				$retirement = $memo->acceptRetirement() ? $memo->retirementStatus() : "";
				$retirement = "";
				$attachment = $memo->hasAttachment() ? "<i class='fa fa-file'></i>" : "";
				$last_minuted =  $memo->type ."(".$memo->status.")<br>".$retirement."<br>".$memo->readStatus()." ".$attachment;
				$last_minute_to= "";
				$minuting= "";


				$last_user = $last_minute_to.'<br>'.$minuting;

				$html .= '
			<tr style="">
                <td>' . $index++ . '</td>
                <td>' . $memo->reference . '</td>
                <td><a href="' . route("memos.show", $memo->id) . '">' . $memo->title . '</a></td>
                <td>' . $sender . '</td>
				<td>' . $receiver . '</td>
                <td>'.date('M jS, Y', strtotime($memo->date_raised)).'</td>
                <td>'.$last_minuted.'</td>
                <td>'.$memo->created_at.'</td>
            </tr>';
			}
			return $html;*/

            return view('pages.memos.filter',compact('memos', 'filter', 'search', 'from', 'to'));

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

    public function kiv(Memo $memo){
        $user = auth()->id();
        if($memo->kiv()){
            MemoKiv::where(['user_id'=>$user, 'memo_id'=>$memo->id])->delete();
            return back()->with('success', 'Keep-in-View is now active on this memo');
        }
        $kiv = new MemoKiv();
        $kiv->user_id = $user;
        $kiv->memo_id = $memo->id;
        $kiv->save();
        return back()->with('success', 'Keep-in-View is now active on this memo');
    }

    public function approveStatus(Request $request){
        try{
            $memo_id = $request->memo_id;
            $approval = new MemoApproval();
            $approval->memo_id = $memo_id;
            $approval->approval = MemoApproval::APPROVAL_PAYMENT;
            $approval->user_id = auth()->id();
            $approval->save();
            return back()->with('success', 'Payment has been approved');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function approvalPayment(Request $request){
        try{
            $memo_id = $request->memo_id;
            $approval = new MemoApproval();
            $approval->memo_id = $memo_id;
            $approval->approval = MemoApproval::APPROVAL_PAYMENT;
            $approval->user_id = auth()->id();
            $approval->save();
            return back()->with('success', 'Payment has been approved');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function approvals(Request $request){
        try{
            if($request->approve){
                $approval = MemoApproval::where('memo_id', $request->approve)->first();
                if(!$approval)
                    $approval = new MemoApproval();
                $memo_id = $request->approve;
                $approval->memo_id = $memo_id;
                $approval->approval = "Approved";
                $approval->approved_by = auth()->id();
                $approval->save();

                //change vehicle status
                $vehicle = Vehicle::find($request->vehicle);
                $vehicle->status = Vehicle::STATUS_IN_TRANSIT;
                $vehicle->save();
                return back()->with('success', 'Approval granted');
            }
            if($request->authorize){
                $approval = MemoApproval::where('memo_id', $request->authorize)->first();
                if(!$approval)
                    $approval = new MemoApproval();
                $memo_id = $request->authorize;
                $approval->memo_id = $memo_id;
                $approval->approval = "Authorized";
                $approval->authorized_by = auth()->id();
                $approval->save();
                return back()->with('success', 'Request authorized');
            }
            if($request->verify){
                $approval = MemoApproval::where('memo_id', $request->verify)->first();
                if(!$approval)
                    $approval = new MemoApproval();
                $memo_id = $request->verify;
                $approval->memo_id = $memo_id;
                $approval->approval = "Verified";
                $approval->verified_by = auth()->id();
                $approval->save();
                return back()->with('success', 'Request verified');
            }
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

}
