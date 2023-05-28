<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customers Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('customer')->group(function ()
{
    // Dashboard
    Route::controller(App\Http\Controllers\Customer\DashboardController::class)->group(function ()
    {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    // Profile Section
    Route::controller(App\Http\Controllers\Customer\ProfileController::class)->name('profile.')->group(function () {
        Route::get('/profile', 'edit')->name('edit');
        Route::patch('/profile/{customer}', 'update')->name('update');
        Route::delete('/profile/{customer}', 'destroy')->name('destroy');
    });

    // Visits
    Route::controller(App\Http\Controllers\Customer\VisitController::class)->prefix('visits')->name('visits.')->group(function ()
    {
        Route::get('/', 'index')->name('MyVisits');
    });

    // Feedbacks
    Route::controller(App\Http\Controllers\Customer\FeedbackController::class)->prefix('feedbacks')->name('feeds.')->group(function ()
    {
        Route::get('/', 'index')->name('MyFeeds');

        Route::get('/create/{visit}', 'create')->name('create');
        Route::post('/store/{visit}', 'store')->name('store');
    });

    // Cars
    Route::controller(App\Http\Controllers\Customer\CarsController::class)->prefix('cars')->name('cars.')->group(function ()
    {
        Route::get('/', 'index')->name('show');

        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');

        Route::get('/model', 'getCarModels')->name('getCarModels');
        Route::get('/specs', 'getCarSpecs')->name('getCarSpecs');

        Route::get('/{model_id}/delete', 'destroy')->name('destroy');

    });

    Route::controller(App\Http\Controllers\Customer\AddressCustomerController::class)->prefix('location')->name('location.')->group(function ()
    {
        Route::get('/', 'index')->name('showMechanicsNearMe');
        Route::any('mechanics-near-me', 'show')->name('mechanicsNearMe');
        Route::get('last-location/{lat}/{long}', 'saveLastLocationCustomer')->name('saveLastLocationCustomer');
    });

    Route::controller(App\Http\Controllers\Customer\UserConttroller::class)->prefix('user')->name('user.')->group(function ()
    {
        Route::get('/{user}/get-info', 'getUserInfo')->name('getUserInfo');
    });


    Route::controller(App\Http\Controllers\Customer\ChatCustomerController::class)->prefix('chat')->name('chat.')->group(function ()
    {
        Route::get('/{user}/', 'index')->name('msg');
        Route::get('/store/msg/{user}/{customer}', 'store')->name('store.msg');
        Route::get('/get/msg/{user}/{customer}', 'getLiveMessages')->name('get.msg');
    });



});
