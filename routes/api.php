<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\HousekeepingHistoryController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\OrderController;



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
Route::put('/edit-rooms', [RoomController::class, 'updateRooms']);

//HOUSEKEEPING SCHEDULES
Route::post('/housekeeping', [HousekeepingController::class, 'store']);
Route::get('/housekeeping', [HousekeepingController::class, 'index']);
Route::put('/housekeeping/{id}', [HousekeepingController::class, 'update']);
Route::delete('/housekeeping/{id}', [HousekeepingController::class, 'delete']);

//HOUSEKEEPING HISTORY

Route::post('/housekeeping-history', [HousekeepingHistoryController::class, 'store']);
Route::get('/housekeeping-history', [HousekeepingHistoryController::class, 'index']);

//GUESTS
Route::post('/guests', [GuestController::class, 'store']);
Route::get('/guests', [GuestController::class, 'index']);

//RESERVATIONS
Route::post('/reservations', [ReservationController::class, 'store']);
Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('/reservations-list', [ReservationController::class, 'daily_report']);
Route::get('/edit-reservation/{id}', [ReservationController::class, 'update']);


//ADDONS
Route::get('/addons', [AddonController::class, 'index']);
Route::post('/addons', [AddonController::class, 'store']);
Route::put('/addons/{id}', [AddonController::class, 'update']);
Route::delete('/addons/{id}', [AddonController::class, 'delete']);


//CHARGES
Route::get('/charges', [ChargeController::class, 'index']);
Route::post('/charges', [ChargeController::class, 'store']);
Route::put('/charges/{id}', [ChargeController::class, 'update']);
Route::delete('/charges/{id}', [ChargeController::class, 'delete']);


//PRODUCTS
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::post('/search-products', [ProductController::class, 'searchProd']);

//VENDORS
Route::post('/vendors', [VendorController::class, 'store']);
Route::get('/vendors', [VendorController::class, 'index']);
Route::put('/vendors/{id}', [VendorController::class, 'update']);

//ORDERS
Route::post('/create-order', [OrderController::class, 'store']);