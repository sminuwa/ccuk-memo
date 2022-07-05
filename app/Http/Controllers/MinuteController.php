<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use App\Models\AttachmentUrl;
use App\Models\Memo;
use App\Models\MemoStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Minute;
use App\Models\User;
use Illuminate\Support\Facades\DB;


/**
 * Description of MinuteController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class MinuteController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth","permission"]);
    }
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.minutes.index', ['records' => Minute::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Minute $minute)
    {
        return view('pages.minutes.show', [
                'record' =>$minute,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$users = User::all(['id']);
		$users = User::all(['id']);

        return view('pages.minutes.create', [
            'model' => new Minute,
			"users" => $users,
			"users" => $users,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->confidentiality == "on") {
            $confidentiality = "confidential";
        }else{
            $confidentiality = "not confidential";
        }
        $user_id = auth()->id();

        DB::table("memos")->where('id', $request->memo_id)->update(["read_status" => "not seen", 'updated_at'=>now()->toDateTimeString()]);

        $model=new Minute;
        $model->memo_id = $request->memo_id;
        $model->body = $request->minute;
        $model->flag = 'positive';
        $model->from_user = $user_id;
        $model->to_user = $request->minuteto;
        $model->confidentiality = $confidentiality;
        $model->copy = '';
        $model->status = 'not seen';
        if ($model->save()) {
            $statuses = MemoStatus::where(['send_from'=>$user_id, 'send_to'=>$request->minuteto, 'model_id'=>$request->memo_id,'model'=>'Minute'])->first();
            if(!$statuses)
                $statuses = new MemoStatus();
            $statuses->send_from = $user_id;
            $statuses->send_to = $request->minuteto;
            $statuses->status = MemoStatus::STATUS_NOT_SEEN;
            $statuses->model_id = $request->memo_id;
            $statuses->model = "Minute";
            $statuses->save();
            if ($request->file()) {
                $attachment_name = $request->attachment_name;
                $attachment = $request->attachment;
                $attach = array();
                for ($i = 0; $i < count($attachment); $i++) {
                    $fileName = time() . '_' . $attachment[$i]->getClientOriginalName();
                    if ($attachment[$i]->move(base_path('public/files'), $fileName)) {
                        $attach[] = [
                            "name"=>'files/'.$fileName,
                            "usrName"=>$attachment_name[$i],
                            "size"=>'',//$attachment[$i]->getMimeType(),
                            "type"=>'',//$attachment[$i]->getSize(),
                            "thumbnail"=>"",
                            "thumbnail_type"=>"",
                            "thumbnail_size"=>"",
                            "searchStr"=>""
                        ];//$fileName;
                    }
                }
                $att_model = new Attachement();
                $att_model->model_id = $model->id;
                $att_model->title = "";
                $att_model->attachment = json_encode($attach);
                $att_model->type = 'Minute';
                $att_model->save();
            }
            //activity()->on($model)->log('New minute');
            session()->flash('app_message', 'Memo saved successfully');
            return redirect()->back()->with('message', 'Minuted successfully');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Memo');
        }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Minute $minute)
    {
		$users = User::all(['id']);
		$users = User::all(['id']);

        return view('pages.minutes.edit', [
            'model' => $minute,
			"users" => $users,
			"users" => $users,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Minute $minute)
    {
        $minute->fill($request->all());

        if ($minute->save()) {

            session()->flash('app_message', 'Minute successfully updated');
            return redirect()->route('minutes.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Minute');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  Minute  $minute
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Minute $minute)
    {
        if ($minute->delete()) {
                session()->flash('app_message', 'Minute successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Minute');
            }

        return redirect()->back();
    }

    public function cancel(Minute $minute){
        if($minute->status == 'not seen')
            $minute->delete();
        return back()->with('success','Minute has been cancelled');
    }
}
