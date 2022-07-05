<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Group;
use App\Models\PayrollPayslip;
use App\Models\PayrollUser;
use App\Models\Position;
use App\Models\Qualification;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\VehicleDriver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


/**
 * Description of UserController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth","permission"]);
//        return response(Route::currentRouteName());
    }


    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('pages.users.index', compact('users'));
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        $department = $user->department();
        $departments = Department::orderBy("name","ASC")->get();
        $branch = $user->branch() ?? 'No';

        $states = State::orderBy('name', 'asc')->get();
        $qualifications = Qualification::orderBy('name', 'asc')->get();

        $ms = ['Divorced', 'Married', 'Single', 'Widowed', 'Separated'];
        $sts = ['active', 'fired', 'retired', 'resigned', 'deceased'];
        return view('pages.users.show', [
            'record' => $user,
            'user_info' => $user->details(),
            'branches' => Branch::orderBy('name','ASC')->get(),
            'branch' => $branch,
            'colleagues'=> $user->colleagues(),
            'departments' => $departments,
            'department' => $department,
            "ms" => $ms,
            "sts" => $sts,
            "states" => $states,
            "qualifications" => $qualifications

        ]);

    }

    public function create()
    {
        $states = State::orderBy('name', 'asc')->get();
        $qualifications = Qualification::orderBy('name', 'asc')->get();
        return view('pages.users.create', compact('states', 'qualifications'));
    }

    public function store(Request $request)
    {
	    try{
            $user = User::where('username', $request->username)->first();
            if($user)
                return back()->with('error', 'Staff with this ('.$request->username.') username already exist. Please change another username');
            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->position_id = $request->position_id;
            $user->password = bcrypt("123456");
            if ($user->save()) {
                $detail = new UserDetail();
                $detail->user_id = $user->id;
                $detail->surname = $request->surname;
                $detail->first_name = $request->first_name;
                $detail->other_names = $request->other_names;
                $detail->gender = $request->gender;
                $detail->department_id = $request->department_id;
                $detail->branch_id = $request->branch_id;
                $detail->position_id = $request->position_id;
                $detail->personnel_number = $request->personnel_number;
                $detail->contact_address = $request->contact_address;
                $detail->phone = $request->phone;
                $detail->status = 'active';
                $detail->marital_status = $request->marital_status;
                $detail->state_of_origin = $request->state_of_origin;
                $detail->state_of_residence = $request->state_of_residence;
                $detail->entry_qualification = $request->entry_qualification;
                $detail->highest_qualification = $request->highest_qualification;
                $detail->save();
                //activity()->on($user)->log('New User Added');
            }
            return redirect()->route('users.show', $user->id)->with('success', 'New user created successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, User $user)
    {
        return view('pages.users.edit', [
            'model' => $user,

        ]);
    }

    public function update(Request $request, User $user)
    {
        try{
            if(!$user)
                $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->position_id = $request->position_id;
            $user->password = bcrypt("123456");
            if ($user->save()) {
                $detail = UserDetail::where('user_id', $user->id)->first();
                if(!$detail)
                    $detail = new UserDetail();
                $detail->user_id = $user->id;
                $detail->surname = $request->surname;
                $detail->first_name = $request->first_name;
                $detail->other_names = $request->other_names;
                $detail->gender = $request->gender;
                $detail->department_id = $request->department_id;
                $detail->branch_id = $request->branch_id;
                $detail->position_id = $request->position_id;
                $detail->personnel_number = $request->personnel_number;
                $detail->contact_address = $request->contact_address;
                $detail->phone = $request->phone;
                $detail->marital_status = $request->marital_status;
                $detail->state_of_origin = $request->state_of_origin;
                $detail->state_of_residence = $request->state_of_residence;
                $detail->entry_qualification = $request->entry_qualification;
                $detail->highest_qualification = $request->highest_qualification;
                $detail->save();
                //activity()->on($user)->log('User updated');
            }
            return redirect()->route('users.show', $user->id)->with('success', 'New user created successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            session()->flash('app_message', 'User successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting User');
        }

        return redirect()->back();
    }

    public function profileImg(Request $request,$id)
    {
        $matric = str_replace("/","_",strtoupper($id));
        if(file_exists(public_path() .'/user_pics/'. $matric . '.JPG'))
        {
            $pathToFile = public_path()."/user_pics/".$matric.".JPG";
        }else{
            $pathToFile = public_path()."/defaults/user.jpg";
        }

        return response()->file($pathToFile);
    }

    public function search(Request $request,$type)
    {
        $q = $request->search;
        $positions = Position::whereRaw("(name LIKE '%$q%')")->get();
        $users = UserDetail::join("departments",'departments.id','=','user_details.department_id')
            ->select(['first_name','surname','other_names','personnel_number','departments.name as department',"user_id AS id"])
            ->whereRaw("(first_name LIKE '%$q%') OR (surname LIKE '%$q%') OR (other_names LIKE '%$q%')")->get();
        $bank = [];
        foreach ($users as $user){
            $bank[] = ["text"=>ucfirst($user->department)." Department : ".$user->surname.', '.$user->first_name . ' ' .$user->other_names.' ('.$user->personnel_number.')',"id"=>$user->id];
        }

        if($type!='staff'){
            foreach ($positions as $position){
                $bank[] = ["text"=>$position->name,"id"=>"p".$user->id];
            }
            foreach (Group::all() as $group){
                $bank[] = ["text"=>$group->name,"id"=>"g".$group->id];
            }
            foreach (Department::all() as $department){
                $bank[] = ["text"=>$department->name,"id"=>"d".$department->id];
            }

        }

        return $bank;
    }

    public function searchAll(Request $request,$type)
    {
        $q = $request->search;
        $bank = [];
        $positions = Position::whereRaw("(name LIKE '%$q%')")->pluck('id')->toArray();
        $p = implode(',', array_filter($positions));

        $users = UserDetail::join("departments",'departments.id','=','user_details.department_id')
            ->join('users', 'users.id', '=', 'user_details.user_id')
            ->select(['first_name','surname','other_names','personnel_number','departments.name as department',"user_id AS id"])
            ->whereRaw("((first_name LIKE '%$q%') OR (surname LIKE '%$q%') OR (other_names LIKE '%$q%') OR (personnel_number LIKE '%$q%')) AND users.status = 'active'")
            ->get();
        foreach ($users as $user){
            $bank[] = ["text"=>ucfirst($user->department)." Department : ".$user->surname.', '.$user->first_name . ' ' .$user->other_names.' ('.$user->personnel_number.')',"id"=>$user->id];
        }

        return $bank;

    }

    public function signature(Request $request){
        try{
            if($request->uxsrrh_ip0dx){
                $id = $request->uxsrrh_ip0dx;
                $user = User::find($id);
                if(!$user)
                    return back()->with('error','Invalid User record');
                $signature = $request->signature;
                $signName = time().'_'.$signature->getClientOriginalName();
                $sign[] = ["name" => $signName, "usrName" => $signName, "size" => $signature->getSize(), "type" => $signature->getMimeType(), "searchStr" => ""];
                if ($signature->move(base_path('public/signatures'), $signName)) {
                    $user->signature = json_encode($sign);
                    $user->save();
                }
            }
            return back()->with('success', 'Signature updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function passwordReset(Request $request){
        try{
            $id = $request->uxsrrh_ip0dx;
            $user = User::find($id);
            if (!$user)
                return back()->with('error','Invalid User record');
            $curp = $request->currentPassword;
            $newp = $request->newPassword;
            $conp = $request->confirmPassword;
            if (!($newp === $conp))
                return back()->with('error','Password didn\'t match');
            if($request->currentPassword) {
                if (password_verify($curp, $user->getAuthPassword())) {
                    $user->password = bcrypt($newp);
                    $user->save();
                }
            }else{
                $user->password = bcrypt($newp);
                $user->save();
            }
            return back()->with('success', 'Password changed');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function userStatus(User $user){
//        return $user;
        if($user->status == User::STATUS_ACTIVE){
            $user->status = User::STATUS_INACTIVE;
            $user->save();
            return back();
        }
        if($user->status == User::STATUS_INACTIVE){
            $user->status = User::STATUS_ACTIVE;
            $user->save();
            return back();
        }
        return back();
    }

    public function myPayslips(){
        $user = auth()->user();
        $months = PayrollPayslip::select(DB::raw("MONTHNAME(date) as month"))->distinct()->orderBy('date', 'desc')->pluck('month');
        $users = User::select('users.*')
            ->join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
//            ->where('payroll_users.status', PayrollUser::STATUS_ACTIVE)
            ->orderBy('users.id', 'asc')->get();
        /*return $months;*/
        return view('pages.payroll.staff.show', compact('user'));
    }

}
