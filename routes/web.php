<?php

use App\Label\Controllers\LabelController;
use App\Task\Controllers\TaskController;
use App\TaskStatus\Controllers\TaskStatusController;
use App\User\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resources([
    'task_statuses' => TaskStatusController::class,
    'labels' => LabelController::class,
    'tasks' => TaskController::class,
]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
