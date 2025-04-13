<?php

namespace App\Http\Controllers\Project;

use App\Models\Remark;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RemarkController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string',
            'date' => 'nullable|date'
        ]);

        if ($task->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $remark = $task->remarks()->create([
            'date' => $request->date ? $request->date : Carbon::now(),
            'content' => $request->content
        ]);

        return response()->json(['message' => 'Remark added', 'remark' => $remark]);
    }
}
