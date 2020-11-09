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
                <h3 class="text-2xl">Projects</h3>
                <a href="{{ route("projects.create") }}" class="bg-white text-gray-500 px-3 py-3">New Project</a>
            </header>

            <div class="w-full p-6 overflow-x-auto">
                @if($projects->isNotEmpty())                    
                    <table class="table-fixed w-full">
                        <thead>
                            <tr>
                                <th class="w-3/4 px-4 py-2">Title</th>
                                {{-- <th class="px-4 py-2">Start Date</th>
                                <th class="px-4 py-2">End Date</th> --}}
                                <th class="w-1/4 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $project->name }}</td>
                                        {{-- <td class="border px-4 py-2">{{ $project->start_date }}</td>
                                        <td class="border px-4 py-2">{{ $project->end_date }}</td> --}}
                                        <td class="border px-4 py-2 flex sm:flex-row justify-center space-x-2 overflow-x-auto"> 
                                            <a href="{{ route("projects.tasks.index", $project->id) }}" class="bg-blue-400 text-white px-3 py-3">Tasks</a>
                                            <a href="{{ route("projects.edit", $project->id) }}" class="bg-gray-300 text-gray-600 px-3 py-3">Edit</a>
                                            <form method="POST" action="{{ route("projects.destroy", $project->id) }}">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="bg-red-400 text-white px-3 py-3">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                @else                
                    <p class="text-gray-700">
                        Create your first project
                    </p>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection