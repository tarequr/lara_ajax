<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', [EmployeeController::class,'index'])->name('emloyee.index');
Route::get('/employee/all-data', [EmployeeController::class,'allData'])->name('emloyee.all.data');
Route::post('/employee/store', [EmployeeController::class,'store'])->name('emloyee.store');
Route::get('/employee/edit/{id}', [EmployeeController::class,'edit'])->name('employee.edit');
Route::put('/employee/update/{id}', [EmployeeController::class,'update'])->name('employee.update');
Route::post('/employee/destroy/{id}', [EmployeeController::class,'destroy'])->name('employee.destroy');

// Route::get('/', [TodoController::class,'index'])->name('todo.index');
// Route::get('/todo/edit/{id}', [TodoController::class,'edit'])->name('todo.edit');
// Route::post('/todo/store', [TodoController::class,'store'])->name('todo.store');
// Route::put('/todo/update/{id}', [TodoController::class,'update'])->name('todo.update');
// Route::post('/todo/destroy/{id}', [TodoController::class,'destroy'])->name('todo.destroy');