<?php

use Illuminate\Support\Facades\Route;
use App\Auth\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Password Reset Routes
|--------------------------------------------------------------------------
|
| Two-step password reset flow:
|   1. GET  /reset-password         — Show email input form
|   2. POST /request-reset          — Generate & return reset token
|   3. GET  /reset-password/{token} — Show new password form (with token & email)
|   4. POST /reset-password         — Validate token & update password
|
*/

// Step 1: Show the "Forgot Password" email input form
Route::get('/reset-password', function () {
    return view('forgot-password-request');
})->name('password.request');

// Step 2: Handle email submission — generate reset token
Route::post('/request-reset', [AuthController::class, 'requestReset'])
    ->middleware('throttle:5,1')
    ->name('password.email');

// Step 3: Show the "Set New Password" form with pre-filled token & email
Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('reset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
})->middleware('guest')->name('password.reset');

// Step 4: Handle password reset form submission — update password, no auto-login
Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('status', 'Email verified successfully!');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Dashboard & Utility Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::post('/logout', function () {
    auth()->guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
