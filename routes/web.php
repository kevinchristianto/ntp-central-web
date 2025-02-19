<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('lines', LineController::class);
    });
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('user', [LogController::class, 'user_logs'])->name('user');
        Route::get('clock', [LogController::class, 'clock_logs'])->name('clock');
        Route::get('misc', [LogController::class, 'misc_logs'])->name('misc');
    });
    Route::resource('clocks', ClockController::class);
    Route::get('configure-clock/{id}', [ClockController::class, 'configure'])->name('clocks.configure');
    Route::resource('users', UserController::class);
    Route::patch('toggle-user-status/{user}', [UserController::class, 'toggle_status'])->name('users.toggle_status');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return view('pages.auth.login');
    })->name('login');
    Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});