<?php

namespace App\Http\Livewire;

use App\Models\MemoStatus;
use App\Models\Minute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;

class MemoAll extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '', $searchby, $memoNumber,  $ringBool = false, $status;

    /*public function updatingSearch()
    {
        $this->resetPage();
    }*/

    public function render(Request $request)
    {
        $user = auth()->id();
        switch ($this->searchby){
            case 'sent': $clause = "raise_by=$user"; break;
            case 'received' : $clause = "raised_for=$user"; break;
            case 'copied' : $clause = "raise_by != $user and raised_for != $user"; break;
            /*case 'unseen' : $clause = "read_status = 'not seen'"; break;
            case 'seen' : $clause = "read_status = 'seen'"; break;
            case 'read' : $clause = "read_status = 'read'"; break;*/
            default: $clause = 1;
        }
        switch ($this->searchby){
            case 'unseen' : $statusClause = "status = 'not seen'"; break;
            case 'seen' : $statusClause = "status = 'seen'"; break;
            case 'read' : $statusClause = "status = 'read'"; break;
            default: $statusClause = 1;
        }
        /*$status = MemoStatus::select('model_id')->whereRaw("$statusClause")->pluck('model_id');
        $status = implode(',',$status);
        $this->status = $status;*/
        $search = "memos.title like '%$this->search%' OR memos.reference like '%$this->search%' OR memos.body like '%$this->search%'";

        $u = auth()->id();
        
	        switch ($request->param) {
		        case 'hour' :
//                $memoClause = "memos.created_at >= DATE_SUB(NOW(),INTERVAL 2 HOUR)";
//                $recode = \App\Models\Memo::select('memos.*')->whereRaw("(memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id)) AND memos.created_at >= DATE_SUB(NOW(),INTERVAL 2 HOUR)")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc');
			        $recode = auth()->user()->twoHoursMemosAll();
			        break;
		        case 'day' :
//                $memoClause = "memos.created_at >= ( CURDATE() - INTERVAL 2 DAY )";
//                $recode = \App\Models\Memo::select('memos.*')->whereRaw("(memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id)) AND memos.created_at >= ( CURDATE() - INTERVAL 2 DAY )")->join('minutes', 'minutes.memo_id', '=', 'memos.id')->orderBy('memos.updated_at', 'desc');
			        $recode = auth()->user()->twoDaysMemosAll();
			        break;
		        case 'week' :
//                $memoClause = "(memos.created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND memos.created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY)";
//                $recode = \App\Models\Memo::select('memos.*')->whereRaw("(memos.status = 'open' AND memos.type = 'Memo' AND minutes.id = (SELECT max(id) FROM minutes WHERE minutes.memo_id=memos.id)) AND (memos.created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND memos.created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY)");
			        $recode = auth()->user()->oneWeekMemosAll();
			        break;
		        case 'myhour' :
			        $recode = auth()->user()->twoHoursMemos();
			        break;
		        case 'myday' :
			        $recode = auth()->user()->twoDaysMemos();
			        break;
		        case 'myweek' :
			        $recode = auth()->user()->oneWeekMemos();
			        break;
		        case 'all':
			        $recode = \App\Models\Memo::whereRaw("memos.status = 'open' AND $search ORDER BY updated_at DESC");
			        break;
		        default:
			        $recode = auth()->user()->memo();
	        }
	        $records = $recode->paginate(10);
        
	    if(!$records)
	    	$records = auth()->user()->memo()->paginate(10);
	    
        //mark to seen
//        mark seen depends on
        /*
         * 1. only if you are the receiver of the memo
         * 2. only if you are the last minute receiver of the memo
         * */
        /*$lastMinute = \App\Models\Memo::join('minutes', 'minutes.memo_id', '=', 'memos.id')
            ->where('to_user', $user)
            ->orWhere(['memos.raised_for' => $user, 'minutes.to_user'=>$user])
            ->where('memos.read_status','not seen')->update(['read_status'=>'seen'])
            /*->get('memos.read_status');*/
//        DB::table("memos")->where(["read_status" => "not seen", "raised_for" => Auth::id()])->update(["read_status" => "seen"]);
        DB::table("memo_statuses")->where(['send_to'=>$user, 'status'=>MemoStatus::STATUS_NOT_SEEN])->update(['status'=>'seen']);
        return view('livewire.memo-all', ['records'=>$records]);
    }
}
