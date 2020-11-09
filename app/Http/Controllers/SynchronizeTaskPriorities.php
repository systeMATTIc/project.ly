<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class SynchronizeTaskPriorities extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $tasks = collect($request->tasks);

        $tasks->each(function ($task) {
            /** @var Task  */
            $storedTask = Task::find($task['id']);

            if (is_null($storedTask)) {
                return false;
            }

            $storedTask->update(['priority' => $task['newPriority']]);
        });

        $request->session()->flash("status", "Task Priorities Updated");

        return response()->json(['message' => "Priorites Synchronized"]);
    }
}
