<?php

use App\Http\Controllers\Apis\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'api_user_login']);
Route::post('/verify-login', [UserController::class, 'app_verify_otp']);
Route::post('/register', [UserController::class, 'api_register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user-update', [UserController::class, 'api_user_update']);
    Route::post('/logout', [UserController::class, 'app_logout']);
});
