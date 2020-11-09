<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;

class ProjectTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return view("tasks.index", [
            "project" => $project,
            "tasks" => $project->incompleteTasks()->orderBy('priority')->get(),
            "completedTasks" => $project->completedTasks()->orderBy('updated_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        return view("tasks.create", ["project" => $project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTaskRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request, Project $project)
    {
        $project->tasks()->create($request->validated());

        $request->session()->flash('status', "Task Created Successfully");

        return redirect()->action([self::class, "index"], ["project" => $project->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Task $task)
    {
        return view("tasks.edit", [
            "project" => $project,
            "task" => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTaskRequest  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $task->update($request->validated());

        $request->session()->flash('status', "Task Updated Successfully");

        return redirect()->action([self::class, "index"], ["project" => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        request()->session()->flash('status', "Task Deleted Successfully");

        return redirect()->action([self::class, "index"], ["project" => $project->id]);
    }
}
