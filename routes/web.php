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

	Route::resource('projects', ProjectController::class);

	Route::post('projects/{project}/tasks', [ProjectTaskController::class, 'store'])->name('project.task.store');
	Route::patch('projects/{project}/tasks/{task}', [ProjectTaskController::class, 'update']);
});

require __DIR__.'/auth.php';
