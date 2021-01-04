<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
	Route::get('projects', [ProjectController::class, 'index'])->name('projects');
	Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
	Route::get('projects/{project}', [ProjectController::class, 'show']);
	Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
	Route::patch('projects/{project}', [ProjectController::class, 'update']);
	Route::post('projects', [ProjectController::class, 'store']);

	Route::post('projects/{project}/tasks', [ProjectTaskController::class, 'store'])->name('project.task.store');
	Route::patch('projects/{project}/tasks/{task}', [ProjectTaskController::class, 'update']);
});

require __DIR__.'/auth.php';
