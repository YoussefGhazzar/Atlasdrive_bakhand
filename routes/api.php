<?php

use App\Http\Controllers\AdminController as ControllersAdminController;
use App\Http\Controllers\AgenceController as ControllersAgenceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AgenceController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\AgencyRegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClientController as ControllersClientController;
use App\Http\Controllers\ProfileController as ControllersProfileController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/plans', [AuthController::class, 'plans']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register/client', [ControllersClientController::class, 'store']);
Route::post('/register/agency', [ControllersAgenceController::class, 'store']);
Route::post('/register/admin', [ControllersAdminController::class, 'store']);

Route::get('/register/agency', [ControllersAgenceController::class, 'index']);
Route::get('/register/client', [ControllersClientController::class, 'index']);
Route::get('/register/admin', [ControllersAdminController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (token required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboard', [AuthenticatedSessionController::class, 'dashboard']);

    // Profile
    Route::get('/profile', [ControllersProfileController::class, 'show']);
    Route::put('/profile', [ControllersProfileController::class, 'update']);
    Route::delete('/profile', [ControllersProfileController::class, 'destroy']);

    // Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [ControllersAdminController::class, 'index']);
    });

    // Client
    Route::middleware('role:client')->group(function () {
        Route::get('/client/dashboard', [ControllersClientController::class, 'index']);
    });

    // Agency
    Route::middleware('role:agence')->group(function () {
        Route::get('/agence/dashboard', [ControllersAgenceController::class, 'index']);
    });
});