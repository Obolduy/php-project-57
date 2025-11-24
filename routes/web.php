<?php

use App\Label\Controllers\LabelController;
use App\Task\Controllers\TaskController;
use App\TaskStatus\Controllers\TaskStatusController;
use App\User\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/task_statuses', [TaskStatusController::class, 'index'])->name('task_statuses.index');

Route::middleware('auth')->group(function () {
    Route::get('/task_statuses/create', [TaskStatusController::class, 'create'])->name('task_statuses.create');
    Route::post('/task_statuses', [TaskStatusController::class, 'store'])->name('task_statuses.store');
    Route::get('/task_statuses/{id}/edit', [TaskStatusController::class, 'edit'])->name('task_statuses.edit')->where('id', '[0-9]+');
    Route::patch('/task_statuses/{id}', [TaskStatusController::class, 'update'])->name('task_statuses.update')->where('id', '[0-9]+');
    Route::delete('/task_statuses/{id}', [TaskStatusController::class, 'destroy'])->name('task_statuses.destroy')->where('id', '[0-9]+');
});

Route::get('/labels', [LabelController::class, 'index'])->name('labels.index');

Route::middleware('auth')->group(function () {
    Route::get('/labels/create', [LabelController::class, 'create'])->name('labels.create');
    Route::post('/labels', [LabelController::class, 'store'])->name('labels.store');
    Route::get('/labels/{id}/edit', [LabelController::class, 'edit'])->name('labels.edit')->where('id', '[0-9]+');
    Route::patch('/labels/{id}', [LabelController::class, 'update'])->name('labels.update')->where('id', '[0-9]+');
    Route::delete('/labels/{id}', [LabelController::class, 'destroy'])->name('labels.destroy')->where('id', '[0-9]+');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show')->where('id', '[0-9]+');

Route::middleware('auth')->group(function () {
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->where('id', '[0-9]+');
    Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update')->where('id', '[0-9]+');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy')->where('id', '[0-9]+');
});

require __DIR__ . '/auth.php';
