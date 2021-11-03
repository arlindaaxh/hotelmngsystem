<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\HousekeepingHistoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//EMPLOYEES
// Route::resource('employees', EmployeeController::class);
Route::post('/add-employee', [EmployeeController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::put('/edit-employee/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'delete']);


//DEPARTMENTS
Route::get('/departments', [DepartmentController::class, 'index']);
Route::post('/departments', [DepartmentController::class, 'store']);
Route::put('/departments/{id}', [DepartmentController::class, 'update']);
Route::delete('/departments/{id}', [DepartmentController::class, 'delete']);

//ROOMS
Route::post('/add-room', [RoomController::class, 'store']);
Route::get('/rooms', [RoomController::class, 'index']);
Route::put('/edit-room/{id}', [RoomController::class, 'update']);
Route::delete('/rooms/{id}', [RoomController::class, 'delete']);

//HOUSEKEEPING SCHEDULES
Route::post('/housekeeping', [HousekeepingController::class, 'store']);
Route::get('/housekeeping', [HousekeepingController::class, 'index']);
Route::put('/housekeeping/{id}', [HousekeepingController::class, 'update']);
Route::delete('/housekeeping/{id}', [HousekeepingController::class, 'delete']);

//HOUSEKEEPING HISTORY

// Route::post('/housekeeping', [HousekeepingHistoryController::class, 'store']);
// Route::get('/housekeeping', [HousekeepingHistoryController::class, 'index']);