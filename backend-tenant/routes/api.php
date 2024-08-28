<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\TenantService;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Registration
Route::post('/register', [RegisterController::class, 'register']);

// Login
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('tenant')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Products
    Route::apiResource('products', ProductController::class);

    // Cart
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::put('/cart/{itemId}', [CartController::class, 'updateCartItem']);
    Route::delete('/cart/{itemId}', [CartController::class, 'removeCartItem']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
});

Route::get('/create-tenant/{name}', function ($name) {
    TenantService::createTenantDatabase($name);
    return response()->json(['message' => 'Tenant created ' . $name . ' successfully']);
});
