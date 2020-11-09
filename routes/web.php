<?php

use App\Http\Controllers\CompletedTasksController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;
use App\Http\Controllers\SynchronizeTaskPriorities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('projects.index');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource("projects", ProjectsController::class);

    Route::resource("projects.tasks", ProjectTasksController::class);

    Route::post("projects/{project}/tasks/sync-priorities", SynchronizeTaskPriorities::class);

    Route::resource("projects.completed-tasks", CompletedTasksController::class)->only(['update', 'destroy'])
        ->parameters(["completed-tasks" => "task"]);
});
