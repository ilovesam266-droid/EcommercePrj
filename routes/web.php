<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\User\CreateUser;
use App\Livewire\Admin\Images;
use App\Livewire\Admin\Order\EditOrder;
use App\Livewire\Admin\Order\CreateOrder;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Product\CreateProduct;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Product\EditProduct;

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
    Route::post('/user/create', CreateUser::class)->name('create_user');
    Route::get('/images', Images::class)->name('images');
    Route::get('/products', Products::class)->name('products');
    Route::get('/products/create', CreateProduct::class)->name('create_product');
    Route::get('/products/{editingProductId}/edit', EditProduct::class)->name('edit_product');
    Route::get('/orders', Orders::class)->name('orders');
    Route::get('/orders/create', CreateOrder::class)->name('create_order');
});
