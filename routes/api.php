<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductVariantController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::middleware(['auth:api'])->group(function () {
//     Route::middleware([''])
//     Route::apiResource('users', UserController::class);
// });
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});


Route::apiResource('products', ProductController::class);
Route::apiResource('variants', ProductVariantController::class);
// Route::put('products/edit/{id}', [ProductController::class, 'update']);
