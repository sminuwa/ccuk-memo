<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachement;
use App\Models\FormParticular;
use App\Models\GroupMember;
use App\Models\Memo;
use App\Models\Minute;
use App\Models\SyncLog;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function localToRemote()
    {
        try {

            //LTR
            $now = now()->toDateTimeString();
            $lastFile = SyncLog::where('model', 'Attachement')->orderBy('id', 'desc')->first();
            $attachments = Attachement::whereBetween("created_at", [$lastFile->date, $now])->orderBy('created_at', 'desc')->get();
            $attach = [];
            foreach ($attachments as $key => $attachment) {
                $arrFile = json_decode($attachment->attachment, true);
                foreach ($arrFile as $file) {
                    $attach = array_merge($attach, [$file['name']]);
                }
            }
            $AttachResponses = Http::asMultipart();
            foreach ($attach as $key => $attachItem) {
//                return file_get_contents(public_path().'/'.$attachItem);
                $finalFile = fopen(public_path() . '/' . $attachItem, 'r');
//                $responses = $responses->attach('files['.$key.']', file_get_contents(public_path().'/'.$attachItem),['filename'. $key.'.jpg'],['multipart/form-data']);
                $AttachResponses = $AttachResponses->attach('attachment[' . $key . ']', $finalFile);
            }

            $AttachResponses = $AttachResponses->post('http://memo.albabello.com/api/sync-attachments');
//            return $AttachResponses;

//            return $attach;

//            return public_path().'/'.$file[0]['name'];
//                $attach = fopen(public_path().'/'.$file[0]['name'], 'r');
//                $response = $response->attach('file['.$k.']', $file);

            //RTL
            $last = [];
            $models = listModels();
            for ($i = 0; $i < count($models); $i++) {
                SyncLog::whereRaw("model='$models[$i]' AND id NOT IN (SELECT id FROM (SELECT sync_logs.id  FROM sync_logs WHERE model = '$models[$i]' ORDER BY sync_logs.id DESC LIMIT 2) sync_logs );")->delete();
                $lastUpdate = SyncLog::where('model', $models[$i])->orderBy('id', 'desc')->first();
                $date = "";
                if ($lastUpdate)
                    $date = $lastUpdate->date;
                $last = array_merge($last,
                    [$models[$i] => $date]
                );
            }
//            return array_filter($last);
            $responses = Http::asForm()->post('http://memo.albabello.com/api/remote-to-local', [
                'lastDate' => $last
            ]);
            
            if ($responses->successful()) {
                $models = array_filter(json_decode($responses, true));
                $numberOfModels = count($models); //number of models
//                return $models;
                foreach ($models as $model => $records) {
                    $MODEL = 'App\Models\\' . $model;
                    if (count($records) > 0) {
                        foreach ($records as $key => $record) {
	                        $record['created_at'] = Carbon::parse($record['created_at'])->addHour()->toDateTimeString();
	                        $record['updated_at'] = Carbon::parse($record['updated_at'])->addHour()->toDateTimeString();
                            $mdl = $MODEL::find($record['id']); //check if the id exist in the local database
                            if (!$mdl or $mdl == "") {
                                $mdl = new $MODEL();
                                $mdl->fill($record);
                                $mdl->save();
                            } else {
                                $mdl->update($record);
                                $mdl->save();
                            }
                        }
                    }
                    $syncLog = new SyncLog();
                    $syncLog->model = $model;
                    $syncLog->direction = SyncLog::DIRECTION_RTL;
                    $syncLog->date = $now;
                    $syncLog->save();
                    $MODEL = "";
                    sleep(0.002);
                }
                return $numberOfModels . ' table(s) updated with '.$AttachResponses. ' on '.$now;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function syncAttachments(Request $request)
    {
        if(!$request->attachment){
            return 'No attachment';
        }
        $attachment = $request->attachment;
        for ($i = 0; $i < count($attachment); $i++) {
            $fileName = $attachment[$i]->getClientOriginalName();
            $attachment[$i]->move(base_path('public/files'), $fileName);
        }
        return count($attachment).' Attachments';
    }

    public function remoteToLocal(Request $request)
    {
        try {
            $this->validate($request, ['lastDate' => 'required']);
            $lastDate = $request->lastDate;
            $models = listModels();
            $now = now()->toDateTimeString();
            $responses = [];
            for ($i = 0; $i < count($models); $i++) {
                $model = 'App\Models\\' . $models[$i];
                if (array_key_exists($models[$i], array_filter($lastDate))) {
                    $records = $model::orderBy('id', 'asc')->whereBetween('updated_at', [$lastDate[$models[$i]], $now])->get();
                } else {
                    $records = $model::orderBy('id', 'asc')->get();
                }
                $responses = array_merge($responses, [$models[$i] => $records]);
            }
            return $responses;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
