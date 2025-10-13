<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Users;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Check action view
 */
// Route::prefix('admin')->name('admin.')->group(function(){
//         Route::view('/', 'admin.pages.auth.login')->name('login');
//         Route::view('/login', 'admin.pages.auth.login')->name('login');
//         Route::view('/register', 'admin.pages.auth.register')->name('register');
//         Route::view('/forgot-password', 'admin.pages.auth.forgot')->name('password.request');
//         Route::view('/dashboard', 'admin.pages.dashboard')->name('dashboard');
//         Route::view('/alert', 'admin.components.alert')->name('alert');
// });

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/login', [AuthController::class, 'loginShow'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', Users::class)->name('user');
});
