<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class CompletedTasksController extends Controller
{
    public function update(Request $request, Project $project, Task $task)
    {
        abort_unless($project->user()->is($request->user()), 404);

        abort_unless($task->project()->is($project), 404);

        $task->update(['is_completed' => true]);

        $request->session()->flash("status", "Task Completed");

        return redirect()->route('projects.tasks.index', ['project' => $project->id]);
    }

    public function destroy(Request $request, Project $project, Task $task)
    {
        abort_unless($project->user()->is($request->user()), 404);

        abort_unless($task->project()->is($project), 404);

        $task->update(['is_completed' => false]);

        $request->session()->flash("status", "Task Reopened");

        return redirect()->route('projects.tasks.index', ['project' => $project->id]);
    }
}
