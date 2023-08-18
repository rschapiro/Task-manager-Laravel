<?php

use App\Http\Controllers\TaskController;
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
    return view('welcome');
});

Route::prefix('tasks')->group(function(){
    Route::get('list', [TaskController::class, 'index'])->name('task.index');
    Route::get('create', [TaskController::class, 'create'])->name('task.create');
    Route::post('save', [TaskController::class, 'store'])->name('task.store');
    Route::get('{id}', [TaskController::class], 'show')->name('task.show');
    Route::get('edit/{id}', [TaskController::class, 'edit'])->name('task.edit');
    Route::post('update/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::post('{task}/destroy', [TaskController::class, 'destroy'])->name('task.destroy');
});



// Route::resource('tasks', TaskController::class);