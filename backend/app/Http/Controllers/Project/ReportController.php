<?php

namespace App\Http\Controllers\Project;

use App\Models\TaskStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Remark;
use App\Models\Task;
class ReportController extends Controller
{
    public function task_details(Request $request)
    {
        $tasks = Task::with('project:id,title') 
                     ->select('id', 'title', 'status', 'project_id', 'created_at'); 

        if (isset($request->project_id)) {
            $tasks->where('project_id', $request->project_id);
        }
    
        if (isset($request->status)) {
            $tasks->where('status', $request->status);
        }
    
        if (isset($request->date)) {
            $tasks->whereDate('created_at', $request->date);
        }
    
        $tasks = $tasks->get();
    
        return response()->json($tasks); 
    }

    public function status_history(Request $request){
        $tasks = TaskStatusHistory::with('task:id,title,project_id', 'task.project:id,title')
                     ->select('id', 'task_id', 'status', 'created_at');
                     
        if (isset($request->project_id)) {

            $tasks->whereHas('task', function ($query) use ($request) {
                $query->where('project_id', $request->project_id);
            });
        }

        if (isset($request->task_id)) {
            
            $tasks->where('task_id', $request->task_id);
        }
    
        if (isset($request->status)) {
        
            $tasks->where('status', $request->status);
        }
    
        if (isset($request->date)) {
            $tasks->whereDate('created_at', $request->date);
        }
    
        $tasks = $tasks->get();
    
        return response()->json($tasks); 
    }

    public function remark_details(Request $request){

        $tasks = Remark::with('task:id,title,project_id', 'task.project:id,title')
                     ->select('id', 'task_id', 'date', 'content');
                        
        if (isset($request->project_id)) {

            $tasks->whereHas('task', function ($query) use ($request) {
                $query->where('project_id', $request->project_id);
            });
        }

        if (isset($request->task_id)) {
            
            $tasks->where('task_id', $request->task_id);
        }
    
        if (isset($request->date)) {
            $tasks->whereDate('date', $request->date);
        }
    
        $tasks = $tasks->get();
    
        return response()->json($tasks); 
    }
    
    
}
