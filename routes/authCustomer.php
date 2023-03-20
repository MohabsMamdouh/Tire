<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('customer')->name('customer.')->group(function ()
    {
        Route::controller(App\Http\Controllers\Customer\Auth\LoginCustomerController::class)->group(function () {
            Route::get('login', 'index')->name('Login');
            Route::post('login/check', 'login')->name('checkLogin');
            Route::post('logout', 'destroy')->name('logout');
        });

        Route::controller(App\Http\Controllers\Customer\Auth\RegisterController::class)->group(function () {
            Route::get('register', 'create')->name('register');
            Route::post('register/check', 'store')->name('register.store');
        });

        Route::controller(App\Http\Controllers\Customer\Auth\PasswordController::class)->group(function () {
            Route::put('password\{customer}', 'update')->name('password.update');
        });
    });
});