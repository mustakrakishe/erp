<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('sign-in', [AuthController::class, 'signIn'])->middleware('guest:sanctum');
    Route::post('sign-out', [AuthController::class, 'signOut'])->middleware('auth:sanctum');
});

Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::post('', [UserController::class, 'create'])->can('create', User::class);
    Route::get('{user}', [UserController::class, 'show'])->can('see', 'user');
});
