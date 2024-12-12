<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Requis à tous les utilisateurs
Route::get('/user', function (Request $request) { 
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('API.v1.0.0')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('otp_code', [AuthController::class, 'checkOtpCode']);
    Route::post('group/{user_id}',[GroupeController::class, 'create_group']);
    
});
