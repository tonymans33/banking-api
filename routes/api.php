<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountDepositController;
use App\Http\Controllers\AccountWithdrawalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnBoardingController;
use App\Http\Controllers\PinController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('onboarding')->group(function () {
        
        Route::post('setup/pin', [PinController::class, 'setupPin']);
        
        Route::middleware('has.set.pin')->group(function () {
            
            Route::post('validate/pin', [PinController::class, 'validatePin']);
            Route::post('generate/account', [AccountController::class, 'store']);
        });
    
    });

    Route::prefix('account')->group(function () {

        Route::post('deposit', [AccountDepositController::class, 'deposit']);
        Route::post('withdraw', [AccountWithdrawalController::class, 'withdraw']);

    });
});
