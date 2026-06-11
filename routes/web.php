<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Customer routes (protected by auth + customer middleware)
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/apply-loan', [CustomerController::class, 'showLoanApplicationForm'])->name('apply-loan');
    Route::post('/apply-loan', [CustomerController::class, 'applyLoan'])->name('apply-loan.post');
    Route::get('/repayment/{loanId}', [CustomerController::class, 'showRepaymentForm'])->name('repayment');
    Route::post('/repayment', [CustomerController::class, 'makeRepayment'])->name('repayment.post');
});

// Admin routes (protected by auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/loans', [AdminController::class, 'loans'])->name('loans');
    Route::post('/loans/{id}/approve', [AdminController::class, 'approveLoan'])->name('approve-loan');
    Route::post('/loans/{id}/reject', [AdminController::class, 'rejectLoan'])->name('reject-loan');
    Route::get('/repayments', [AdminController::class, 'repayments'])->name('repayments');
});
