<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('sign-in', 'signIn')->middleware('guest:sanctum');
    Route::post('sign-out', 'signOut')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('', 'index');
        Route::post('', 'create')->can('create', User::class);
        Route::get('{user}', 'show')->can('see', 'user');
        Route::patch('{user}', 'update')->can('update', 'user');
        Route::delete('{user}', 'delete')->can('delete', 'user');
    });

    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('', 'index');
        Route::post('', 'create')->can('create', Product::class);
        Route::get('{product}', 'show')->can('see', 'product');
    });
});
