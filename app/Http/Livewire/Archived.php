<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Archived extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '', $searchby, $memoNumber,  $ringBool = false, $status;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->id();
        switch ($this->searchby){
            case 'sent': $clause = "raise_by=$user"; break;
            case 'received' : $clause = "raised_for=$user"; break;
            case 'copied' : $clause = "raise_by != $user and raised_for != $user"; break;
            case 'unseen' : $clause = "read_status = 'not seen'"; break;
            case 'seen' : $clause = "read_status = 'seen'"; break;
            case 'read' : $clause = "read_status = 'read'"; break;
            default: $clause = 1;
        }
        $search = "memos.title like '%$this->search%' OR memos.reference like '%$this->search%' OR memos.body like '%$this->search%'";
        $records = \App\Models\Memo::whereRaw("($clause) AND ($search) AND memos.status = 'archived' ORDER BY updated_at DESC")->paginate(10);

        if($this->memoNumber != $records->total()){
            $this->ringBool = true;
            $this->memoNumber = $records->total();
        };
        //mark to seen
        // DB::table("memos")->where(["read_status" => "not seen", "raised_for" => Auth::id()])->update(["read_status" => "seen"]);
        return view('livewire.archived', ['records'=>$records]);
    }
}
