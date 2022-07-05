<?php

namespace App\Http\Livewire;

use App\Models\MemoKiv;
use App\Models\MemoStatus;
use App\Models\Minute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Memo extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '', $searchby, $memoNumber,  $ringBool = false, $status, $perpage = 10;
    public $newMemo,$allMemos, $newReceived, $kivMemo;

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $user = auth()->id();
        $interval = $this->interval();
        $this->newMemos = $this->newMemoFunc();
        $this->newReceived = $this->receivedMemoFunc();
        $this->allMemos = $this->allMemoFunc();
        $this->kivMemo = $this->kivMemoFunc();

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

        $search = "memos.title like '%$this->search%' OR memos.reference like '%$this->search%' OR memos.body like '%$this->search%'";
        switch ($this->status){
            case 'new':
                $records = \App\Models\Memo::whereRaw("(memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open'")->orderBy('memos.id', 'desc')
                    ->paginate($this->perpage);

                break;
            case 'received':
                $records = \App\Models\Memo::whereRaw("($user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) AND memos.status = 'open') OR ((memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' AND read_status != 'read') ORDER BY updated_at DESC")
                    ->paginate($this->perpage);
                break;
            case 'sent':
                $records = \App\Models\Memo::whereRaw("memos.raise_by=$user AND memos.status = 'open' ORDER BY updated_at DESC")
                    ->paginate($this->perpage);
                break;
            case 'copied':
                $records = \App\Models\Memo::whereRaw("FIND_IN_SET('$user',memos.copy) > 0 AND memos.status = 'open' ORDER BY updated_at DESC")
                    ->paginate($this->perpage);
                break;
            case 'kiv':
                $records = \App\Models\Memo::whereRaw("memos.status = 'open' AND memos.id IN (SELECT memo_id FROM memo_kivs WHERE user_id=$user) ORDER BY updated_at DESC")
                    ->paginate($this->perpage);
                break;
            default:
                $records = \App\Models\Memo::whereRaw("(memos.raise_by=$user OR memos.raised_for=$user OR FIND_IN_SET('$user',memos.copy) > 0 OR $user IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND ($clause) AND ($search) AND memos.status = 'open'  ORDER BY updated_at DESC")
                    ->paginate($this->perpage);
        }

        DB::table("minutes")->where(['to_user'=>$user, 'status'=>Minute::STATUS_NOT_SEEN])->update(['status'=>'seen']);
        return view('livewire.memo', ['records'=>$records]);
    }
    public function interval(){
        return "1 MONTH";
    }

    public function newMemoFunc(){
        $user = auth()->id();
        $interval = $this->interval();
        return \App\Models\Memo::whereRaw("(memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' ")->orderBy('memos.id', 'desc')->get()->count();
    }

    public function receivedMemoFunc(){
        $user = auth()->id();
        $interval = $this->interval();
        return \App\Models\Memo::whereRaw("(($user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id )) AND memos.status = 'open') OR ((memos.raised_for=$user AND $user NOT IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) AND $user NOT IN (SELECT to_user FROM minutes WHERE memo_id=memos.id) ) AND memos.status = 'open' ) ORDER BY updated_at DESC")->get()->count();
    }

    public function allMemoFunc(){
        $user = auth()->id();
        $interval = $this->interval();
        return \App\Models\Memo::whereRaw("(memos.raise_by=$user OR memos.raised_for=$user OR FIND_IN_SET('$user',memos.copy) > 0 OR $user IN (SELECT from_user FROM minutes WHERE memo_id=memos.id) OR $user IN (SELECT to_user FROM minutes WHERE memo_id=memos.id)) AND memos.status = 'open'  ORDER BY updated_at DESC")->get()->count();
    }

    public function kivMemoFunc(){
        $user = auth()->id();
        return \App\Models\Memo::whereRaw("memos.status = 'open' AND memos.id IN (SELECT memo_id FROM memo_kivs WHERE user_id=$user) ORDER BY updated_at DESC")->count();
    }
}
