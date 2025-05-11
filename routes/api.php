<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserStatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

    Route::get('/get-customers', [CustomerController::class, 'getCustomers']);
    Route::post('/add-customer', [CustomerController::class, 'addCustomer']);
    Route::put('/edit-customer/{id}', [CustomerController::class, 'editCustomer']);
    Route::delete('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer']);

    // Venue Routes
    Route::get('/get-venues', [VenueController::class, 'getVenues']);
    Route::post('/add-venue', [VenueController::class, 'addVenue']);
    Route::put('/edit-venue/{id}', [VenueController::class, 'editVenue']);
    Route::delete('/delete-venue/{id}', [VenueController::class, 'deleteVenue']);

    // Event Routes
    Route::get('/get-events', [EventController::class, 'getEvents']);
    Route::post('/add-event', [EventController::class, 'addEvent']);
    Route::put('/edit-event/{id}', [EventController::class, 'editEvent']);
    Route::delete('/delete-event/{id}', [EventController::class, 'deleteEvent']);

    // Package Routes
    Route::get('/get-packages', [PackageController::class, 'getPackages']);
    Route::post('/add-package', [PackageController::class, 'addPackage']);
    Route::put('/edit-package/{id}', [PackageController::class, 'editPackage']);
    Route::delete('/delete-package/{id}', [PackageController::class, 'deletePackage']);

    // User Status Routes
    Route::get('/user-status', [UserStatusController::class, 'getUserStatus']);
    Route::put('/user-status', [UserStatusController::class, 'updateUserStatus']);
    Route::put('/user-status/online', [UserStatusController::class, 'updateOnlineStatus']);
    Route::put('/user-status/visibility', [UserStatusController::class, 'updateProfileVisibility']);
    
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});