<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->namespace('App\Http\Controllers\Api\v1')->group(function () {

    // Customers
    Route::apiResource('customers', CustomerApiController::class);
    Route::get('customers/{customer}/show-my-visits', ['uses' => 'CustomerApiController@showMyVisits']);
    Route::get('customers/{customer}/reset-password', ['uses' => 'CustomerApiController@resetPassword']);
});


// // Cars
// route::controller(App\Http\Controllers\Api\CarApiController::class)->prefix('cars')->group(function ()
// {
//     Route::get('/', 'index');
//     Route::get('update-car-list/', 'UpdateCarsFromAPIToDB');
//     Route::get('search/', 'searchCar');
//     Route::get('car-models/', 'getCarModels');
//     Route::get('car-model-specs/', 'getCarSpecs');
// });


// // Feedback
// route::controller(App\Http\Controllers\Api\FeedbackApiController::class)->prefix('feedbacks')->group(function ()
// {
//     Route::get('/', 'index');
//     Route::post('/store', 'store');
//     Route::get('none-accepted/', 'acceptFeed');
//     Route::get('accept/{feedback}', 'accept');
//     Route::get('/destroy/{feedback}', 'destroy');
// });


// // Customer Car Info
// route::controller(App\Http\Controllers\Api\CustomerCarInfoApiController::class)->prefix('Customer/Car')->group(function ()
// {
//     Route::post('/add', 'storeCustomerCar');
//     Route::get('/{cid}/info', 'getCustomerCarsinfo');
//     Route::get('get-customer-car', 'getCustomerCar');
//     Route::get('/destroy/{cid}/{model_id}', 'destroy');

// });


// // Users
// Route::resource('users', App\Http\Controllers\Api\UserApiController::class);
// route::controller(App\Http\Controllers\Api\UserApiController::class)->prefix('users/f')->group(function ()
// {
//     Route::get('/show/all', 'showAll');
//     Route::get('/dashboard', 'dashboard');
//     Route::post('reset-password/{user}', 'resetPassword');
// });

// // Visits
// Route::resource('visits', App\Http\Controllers\Api\VisitApiController::class);
// route::controller(App\Http\Controllers\Api\VisitApiController::class)->prefix('visits/f')->group(function ()
// {
//     Route::get('/showCustomerVisits/{cid}', 'showCustomerVisits');
//     Route::get('search', 'searchVisit');
//     Route::get('getCustomerVisits', 'getCustomerVisits');
// });


// Customer Interface
