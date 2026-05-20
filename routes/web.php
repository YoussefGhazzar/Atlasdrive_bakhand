<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\AgencyRegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('Auth/login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('Auth/logout');

Route::get('/register/client', [RegisteredUserController::class, 'client'])
    ->middleware('guest')
    ->name('register.client');

Route::get('/register/agency', [RegisteredUserController::class, 'agency'])
    ->middleware('guest')
    ->name('agency.register');
Route::post('/register/client', [RegisteredUserController::class, 'registerClient'])
    ->middleware('guest')
    ->name('register.client.store');
Route::post('/register/agency', [RegisteredUserController::class, 'registerAgency'])
    ->middleware('guest')
    ->name('agency.register.store');


Route::get('/dashboard/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'index']   )->name('client.dashboard');
    Route::get('/client/bookings',  [ClientController::class, 'bookings'])->name('client.bookings');
    Route::get('/client/active',    [ClientController::class, 'active']  )->name('client.active');

});

Route::middleware(['auth', 'role:agence'])->group(function () {
    Route::get('/agence/dashboard', [AgenceController::class, 'index'])->name('agency.dashboard');
    
    Route::get('/agency/select-plan', fn () => Inertia::render('pricing'))->name('agency.select-plan');
    Route::get('/agency/payment', [PaymentController::class, 'create'])->name('agency.payment');
    Route::post('/agency/payment', [PaymentController::class, 'store'])->name('agency.payment.store');

 Route::get('/agence/dashboard',  [AgenceController::class, 'overview']      )->name('agency.dashboard');
    Route::get('/agence/overview',   [AgenceController::class, 'overview']      )->name('agency.overview');
    Route::get('/agency/fleet',      [AgenceController::class, 'fleet']    )->name('agency.fleet');
    Route::get('/agency/bookings',   [AgenceController::class, 'bookings'] )->name('agency.bookings');
    Route::get('/agency/earnings',   [AgenceController::class, 'earnings'] )->name('agency.earnings');
    Route::get('/agency/settings',   [AgenceController::class, 'settings'] )->name('agency.settings');
    Route::patch('/agency/settings', [AgenceController::class, 'updateSettings'])->name('agency.settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
