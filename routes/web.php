<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function(){
        Route::view('/', 'admin.pages.auth.login')->name('login');
        Route::view('/login', 'admin.pages.auth.login')->name('login');
        Route::view('/register', 'admin.pages.auth.register')->name('register');
        Route::view('/forgot-password', 'admin.pages.auth.forgot')->name('password.request');
        Route::view('/dashboard', 'admin.pages.dashboard')->name('dashboard');
        Route::view('/alert', 'admin.components.alert')->name('alert');
});