<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('sign-in', [AuthController::class, 'signIn'])->middleware('guest:sanctum');
});
