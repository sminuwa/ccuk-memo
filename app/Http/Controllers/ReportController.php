<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Memo;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware(["auth"]);
        $this->middleware('permission:reports.index');

    }

    public function index() {
        return view('pages.reports.index');
    }

    public function loadReports(Request $request) {
        $reportType = $request->report_type;
        $reportBy = $request->report_by;
        $memos = null;
        if ($reportBy && $reportBy == 'staff') {
            $user = User::find($request->staff);
            if (!$u = $user->id)
                return back()->with('error', 'No staff is selected');
            $memos = Memo::select('memos.*')->whereRaw("(memos.raise_by=$u OR memos.raised_for=$u OR FIND_IN_SET('$u',memos.copy) > 0 OR $u IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $u IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND minutes.to_user = $u")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
            $memos2h = Memo::select('memos.*')->whereRaw("((memos.raise_by=$u OR memos.raised_for=$u OR FIND_IN_SET('$u',memos.copy) > 0 OR $u IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $u IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND minutes.to_user = $u) AND memos.updated_at >= DATE_SUB(NOW(),INTERVAL 2 HOUR)")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
            $memos2d = Memo::select('memos.*')->whereRaw("((memos.raise_by=$u OR memos.raised_for=$u OR FIND_IN_SET('$u',memos.copy) > 0 OR $u IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $u IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND minutes.to_user = $u) AND memos.updated_at >= ( CURDATE() - INTERVAL 2 DAY )")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
            $memos1w = Memo::select('memos.*')->whereRaw("((memos.raise_by=$u OR memos.raised_for=$u OR FIND_IN_SET('$u',memos.copy) > 0 OR $u IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $u IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND minutes.to_user = $u) AND memos.updated_at < ( NOW() - INTERVAL 1 WEEK )")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
        } else if ($reportBy && $reportBy == 'department') {
            if (!$d = $request->department)
                return back()->with('error', 'No department is selected');
            $department = Department::find($d);
            $users = User::select('users.id')->join('user_details', 'users.id', '=', 'user_details.user_id')
                ->where('user_details.department_id', $department->id)->pluck('id')->toArray();
            $us = implode(',', $users);
            $uq1 = $uq2 = $uq3 = null;
            for ($i = 0; $i < count($users); $i++) {
                $uq1 = $uq1 . " OR FIND_IN_SET('$users[$i]',memos.copy) > 0 ";
                $uq2 = $uq2 . " OR $users[$i] IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $users[$i] IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ";
                $uq3 = $uq3 . " minutes.to_user = $users[$i] OR";
            }
            $memos = Memo::select('memos.*')->whereRaw("(memos.raise_by IN ($us) OR memos.raised_for IN ($us) $uq1 $uq2) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND ($uq3 0)")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
            $memos2h = Memo::select('memos.*')->whereRaw("((memos.raise_by IN ($us) OR memos.raised_for IN ($us) $uq1 $uq2) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND ($uq3 0)) AND memos.updated_at >= DATE_SUB(NOW(),INTERVAL 2 HOUR)")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
            $memos2d = Memo::select('memos.*')->whereRaw("((memos.raise_by IN ($us) OR memos.raised_for IN ($us) $uq1 $uq2) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND ($uq3 0)) AND memos.updated_at >= ( CURDATE() - INTERVAL 2 DAY )")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
            $memos1w = Memo::select('memos.*')->whereRaw("((memos.raise_by IN ($us) OR memos.raised_for IN ($us) $uq1 $uq2) AND memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id) AND ($uq3 0)) AND memos.updated_at < ( NOW() - INTERVAL 1 WEEK )")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc')->get();
        }
        return view('pages.reports.index', compact('memos', 'memos2h', 'memos2d', 'memos1w', 'reportBy', 'reportType'));

    }
}
