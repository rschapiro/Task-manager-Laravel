<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('tasks/', TaskController::class)->middleware(['auth']);

// Route::prefix('tasks')->group(function(){
//     Route::get('list', [TaskController::class, 'index'])->name('task.index');
//     Route::get('create', [TaskController::class, 'create'])->name('task.create');
//     Route::post('save', [TaskController::class, 'store'])->name('task.store');
//     // Route::get('{id}', [TaskController::class], 'show')->name('task.show');
//     Route::get('edit/{id}', [TaskController::class, 'edit'])->name('task.edit');
//     Route::post('update/{id}', [TaskController::class, 'update'])->name('task.update');
//     Route::post('{task}/destroy', [TaskController::class, 'destroy'])->name('task.destroy');
//     Route::post('complete-task/{id}', [TaskController::class, 'setStatus'])->name('task.complete');
// });