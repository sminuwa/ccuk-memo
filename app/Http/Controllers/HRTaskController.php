<?php

namespace App\Http\Controllers;

use App\Models\HrTask;
use Illuminate\Http\Request;

class HRTaskController extends Controller
{
    //
    public function index(){
        $tasks = HrTask::orderBy('code', 'asc')->get();
        return view('pages.hr.tasks.index', compact('tasks'));
    }

    public function store(Request $request){

        try{
            $task_id = $request->task_id;
            $task = HrTask::find($task_id);
            if(!$task)
                $task = new HrTask();
            $task->code = $request->code;
            $task->name = $request->name;
            $task->description = $request->description;
            $task->duration = $request->duration;
            $task->point = $request->point;
            $task->save();
            return back()->with('success', 'Task added successfully');
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy(HrTask $task){
        try {
            $task->delete();
            return back()->with('success', 'Task deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete task');
        }
    }
}
