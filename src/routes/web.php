<?php

use App\Http\Controllers\AuthController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

#region Dashboard Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', function() {
        return view('admin.users');
    })->name('users');

    Route::get('/app-settings', function() {
        return view('admin.app-settings');
    })->name('app-settings');
});
#endregion

#region Authentication Routes
Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::post('/login/attempt', [AuthController::class, 'login'])->name('login.attempt');
#endregion