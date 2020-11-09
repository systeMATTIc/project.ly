@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header class="flex justify-between items-center font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-4 sm:px-8 sm:rounded-t-md">
                <h3 class="text-2xl">Tasks | <span class="text-lg">Project - {{ $project->name }}</span></h3>
                <a href="{{ route("projects.tasks.create", $project->id) }}" class="bg-white text-gray-500 px-3 py-3">New Task</a>
            </header>

            <div class="w-full p-6">
                @if($tasks->isNotEmpty())   
                    <incomplete-tasks :project="{{ json_encode($project) }}" :tasks="{{ json_encode($tasks) }}"></incomplete-tasks>
                @else                
                    <p class="text-gray-700">
                        Create a Task
                    </p>
                @endif
            </div>
        </section>
    </div>


    <div id="completed-tasks" class="w-full sm:px-6 mt-12">
    
        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-4 sm:px-8 sm:rounded-t-md">
                Completed Tasks
            </header>

            <div class="w-full p-6">
                @if($completedTasks->isNotEmpty())                    
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Completed</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Last Modified</th>
                            <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($completedTasks as $task)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $task->name }}</td>
                                        <td class="border px-4 py-2">{{ $task->is_completed ? "Yes" : "No" }}</td>
                                        <td class="border px-4 py-2">{{ $task->created_at }}</td>
                                        <td class="border px-4 py-2">{{ $task->updated_at }}</td>
                                        <td class="border px-4 py-2 flex justify-center space-x-2"> 
                                            <form method="POST" action="{{ route("projects.completed-tasks.destroy", ["project" => $project->id, "task" => $task->id]) }}">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="bg-orange-400 text-white px-3 py-3">Incomplete</button>
                                            </form>
                                        </td>                                    
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                @else                
                    <p class="text-gray-700">
                        Complete a task now...
                    </p>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection