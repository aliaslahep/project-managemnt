<?php

    namespace App\Http\Controllers\Project;

    use App\Models\Project;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;

    class ProjectController extends Controller
    {
        public function index(){
            
            return response()->json(Auth::user()->projects);
        }

        public function store(Request $request){
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $project = Auth::user()->projects()->create($request->all());

            return response()->json(['message' => 'Project created successfully.', 'project' => $project]);
        }

        public function update(Request $request, Project $project){
            
            $this->authorizeProject($project);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $project->update($request->all());

            return response()->json(['message' => 'Project updated.', 'project' => $project]);
        }

        public function destroy(Project $project)
        {
            $this->authorizeProject($project);
            $project->delete();

            return response()->json(['message' => 'Project deleted.']);
        }

        // Restrict access to own projects
        private function authorizeProject(Project $project)
        {
            if ($project->user_id !== Auth::id()) {
                abort(403, 'Unauthorized');
            }
        }
    }
