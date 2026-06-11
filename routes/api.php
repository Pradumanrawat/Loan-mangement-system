<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\RepaymentController;
use Illuminate\Support\Facades\Route;

// Public API routes (stricter rate limit on auth endpoints)
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected API routes (require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/loan/apply', [LoanController::class, 'apply']);
    Route::get('/loan/status', [LoanController::class, 'status']);
    Route::post('/repayment', [RepaymentController::class, 'store']);
});
