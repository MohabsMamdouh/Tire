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

    // Cars
    Route::apiResource('cars', CarApiController::class);
    Route::get('cars/list/update', ['uses' => 'CarApiController@updateCarList']);

    // Customers Car Info
    Route::post('customer/{customer}/cars/store', ['uses' => 'CustomerCarInfoApiController@storeCustomerCar']);
    Route::get('customer/{customer}/cars/', ['uses' => 'CustomerCarInfoApiController@getCustomerCarsinfo']);
    Route::delete('customer/{customer}/cars/delete', ['uses' => 'CustomerCarInfoApiController@destroy']);

    // Feedbacks
    Route::apiResource('feedbacks', FeedbackApiController::class);

    // Users
    Route::apiResource('users', UserApiController::class);
    Route::get('users/show/all', ['uses' => 'UserApiController@showAll']);
    Route::put('users/{user}/reset-password', ['uses' => 'UserApiController@resetPassword']);

    // Visits
    Route::apiResource('visits', VisitApiController::class);

    // Address
    Route::post('address/mechanic/store/', ['uses' => 'AddressApiController@store']);
    Route::get('address/mechanic/near', ['uses' => 'AddressApiController@near']);

});
