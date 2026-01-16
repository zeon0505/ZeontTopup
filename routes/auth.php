<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Route::get('register', \App\Livewire\Auth\Register::class)
        ->name('register');

    Route::get('login', \App\Livewire\Auth\Login::class)
        ->name('login');

    Route::get('forgot-password', \App\Livewire\Auth\ForgotPassword::class)
        ->name('password.request');

    Route::get('reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', \App\Livewire\Auth\VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('confirm-password', \App\Livewire\Auth\ConfirmPassword::class)
        ->name('password.confirm');

    // Logout
    Route::post('logout', function () {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
