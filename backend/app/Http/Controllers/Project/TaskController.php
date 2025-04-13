<?php

namespace App\Http\Controllers\Project;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskStatusHistory;


class TaskController extends Controller
{
    public function store(Request $request, $projectId){

        $project = Project::where('id', $projectId)->where('user_id', Auth::id())->first();
        
        if (!$project) {
            return response()->json(['message' => 'Project not found or unauthorized'], 404);
        }
        
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $task = $project->tasks()->create([
            'title' => $request->title,
            'status' => 'Pending'
        ]);

        return response()->json(['message' => 'Task created', 'task' => $task]);
    }

    public function update_status(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed'
        ]);

        if ($task->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $task->status = $request->status;
        $task->save();

        TaskStatusHistory::create([
            'task_id' => $task->id,
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Status updated', 'task' => $task]);
    }
}
