<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\Payment\Stripe\StripePaymentController;
use App\Http\Controllers\Api\V1\Payment\Stripe\StripeWebhookController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductVariantController;
use App\Http\Controllers\Api\V1\ReviewController;
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

    Route::apiResource('products', ProductController::class);
    Route::apiResource('products.variants', ProductVariantController::class);
    Route::apiResource('products.reviews', ReviewController::class);
    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('orders', OrderController::class);
    Route::post('stripe/payment-intent', [StripePaymentController::class, 'createPaymentIntent']);
    Route::post('stripe/confirm-payment', [StripePaymentController::class, 'confirmPaymentIntent']);
});
    // Route::post('stripe/webhook', [StripeWebhookController::class, 'handle']);
    Route::post('stripe/webhook', [StripeWebhookController::class, 'handle'])
    ->withoutMiddleware([
        'auth:api',
        'auth',
    ]);

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});
