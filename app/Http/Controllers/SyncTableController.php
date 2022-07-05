<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use App\Models\Minute;
use App\Models\SyncTable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SyncTableController extends Controller
{
    //local sync
    public function local(){
        //getting the last sync date
        $lastSyncMemo = SyncTable::where(['model'=>'Memo'])->latest()->first();
        $lastSyncMemo ? $lastSyncMemo = $lastSyncMemo->sync_time : $lastSyncMemo = now()->toDateTimeString();
        $now = now()->toDateTimeString();
        $memos = Memo::whereRaw("`updated_at` BETWEEN '$lastSyncMemo' AND '$now'")->with('minute', 'attachment')->get();

//        print_r(array_filter($memos->attachment));
        foreach ($memos as $memo){
            //memo attachment
            foreach ($memo->attachment as $memoAttachment){
                $obj = json_decode($memoAttachment->attachment);
                foreach($obj as $e){
                    print($e);
                }
            }
        }
//        return $memos;
    }
    // cloud sync
    public function cloud(){

    }
}
