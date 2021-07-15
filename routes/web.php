<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ApiTaskController;
use App\Http\Controllers\TodolistController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('login');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/tasks/{todolist}/list', [TaskController::class, 'index'])->name('tasksview.index');

Route::apiResource('todolists', TodolistController::class);



Route::get('/tasks/{todolist}', [ApiTaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/{todolist}', [ApiTaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}', [ApiTaskController::class, 'show'])->name('tasks.show');
Route::put('/tasks/{task}', [ApiTaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [ApiTaskController::class, 'destroy'])->name('tasks.destroy');

    // Route::apiResource('tasks', TaskController::class);

