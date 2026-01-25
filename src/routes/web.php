<?php

use App\Http\Controllers\AuthController;
use App\Models\AppSetting;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $mapSetting = AppSetting::where('section', 'Web Map')->where('name', 'Enable Map')->first();
    if($mapSetting && $mapSetting->getValue() == true){
        $url = AppSetting::where('section', 'Web Map')->where('name', 'URL')->first()->getValue();
        $port = AppSetting::where('section', 'Web Map')->where('name', 'Port')->first()->getValue();
        $fullUrl = "{$url}:{$port}";
        return view('map', ['url' => $fullUrl]);
    } else
        return view('welcome');
});

Route::get('/faq', function() {
    return view('faq');
});

#region Dashboard Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/server-mods', function() {
        return view('admin.server-mods');
    })->name('server-mods');

    #region User Routes
    Route::get('/users', function() {
        return view('admin.users.index');
    })->name('users');
    #endregion

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