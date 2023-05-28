<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Stuff & Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth', 'verified'])->group(function ()
{

    Route::controller(App\Http\Controllers\UserController::class)->group(function ()
    {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    // Profile Section
    Route::controller(App\Http\Controllers\ProfileController::class)->name('profile.')->group(function () {
        Route::get('/profile', 'edit')->name('edit');
        Route::patch('/profile', 'update')->name('update');
        Route::delete('/profile', 'destroy')->name('destroy');
    });

    // Access Section
    Route::controller(App\Http\Controllers\AccessController::class)->name('access.')->prefix('access')->group(function () {
        Route::get('/', 'showRoles')->name('showRoles')->middleware('can:show roles'); // Done

        Route::group(['middleware' => ['can:create role']], function () {
            Route::get('/create-role', 'createRole')->name('createRole'); // Done
            Route::post('/store-role', 'storeRole')->name('storeRole'); // Done
        });

        Route::group(['middleware' => ['can:assign permission to role']], function () {
            Route::get('/{id}/assign-permission-to-role', 'assignPermissionToRole')
                ->name('assignPermissionToRole'); // Done

            Route::post('/{id}/store-permission-to-role', 'storePermissionToRole')
                ->name('storePermissionToRole'); // Done
        });

        Route::group(['middleware' => ['role:super_admin']], function () {
            Route::get('/make-super-admin', 'makeSuperAdmin')->name('makeSuperAdmin'); // Done
            Route::post('/store-super-admin', 'storeSuperAdmin')->name('storeSuperAdmin'); // Done

            Route::post('/delete-super-admin', 'deleteSuperAdmin')->name('deleteSuperAdmin');
        });

        // Route::get('/assign', 'createRole')->name('assign')
        //         ->middleware('can:show users'); // Done

        Route::group(['middleware' => ['can:assign permission']], function () {
            Route::get('/{id}/assign', 'PermissionAssignToUser')->name('userAssign'); // Done
            Route::post('/{id}/assign', 'StorePermissionAssignToUser')->name('userAssignStore'); // Done

        });

        Route::get('/{id}/delete-role', 'destroyRole')->name('destroyRole')->middleware('can:delete role'); // Done

    });


    // User Section
    Route::controller(App\Http\Controllers\UserController::class)->name('user.')->prefix('users')->group(function () {
        Route::get('/show-all', 'showAll')->name('showAll')->middleware('can:show users'); // Done

        Route::get('/{id}/show', 'show')->name('ShowSingle')->middleware('can:show user'); // Done

        Route::group(['middleware' => ['can:create user']], function () {
            Route::get('/create', 'create')->name('create'); // Done
            Route::post('/store', 'store')->name('store'); // Done
        });

        Route::group(['middleware' => ['can:update user']], function () {
            Route::get('/{id}/edit/', 'edit')->name('edit'); // Done
            Route::post('/{id}/update/', 'update')->name('update'); // Done
            Route::post('/{id}/update-password/', 'resetPassword')->name('updatePassword');
        });

        Route::get('/{id}/delete', 'destroy')->name('destroy')->middleware('can:delete user'); // Done

    });

    // Address Section
    Route::controller(App\Http\Controllers\AddressController::class)->name('address.')->prefix('address')->group(function () {
        Route::name('location.')->prefix('location')->group(function () {
            Route::get('/', 'create')->name('add');
            Route::post('/store', 'store')->name('store');
        });

        Route::any('mechanics-near', 'mechanicsNearME')->name('showMechanicsNearMe');
        Route::any('mechanics-near-me', 'show')->name('mechanicsNearMe');
    });

    // Customer Section
    Route::controller(App\Http\Controllers\CustomerController::class)->name('customer.')->prefix('customers')->group(function () {
        Route::get('/show-all', 'showAll')->name('showAll'); // Done

        Route::get('/{id}/show', 'show')->name('ShowSingle')->middleware('can:show customer'); // Done

        Route::group(['middleware' => ['can:create customer']], function () {
            Route::get('/create', 'create')->name('create'); // Done
            Route::post('/store', 'store')->name('store'); // Done
        });

        Route::group(['middleware' => ['can:update customer']], function () {
            Route::get('/{id}/edit/', 'edit')->name('edit'); // Done
            Route::post('/{id}/update/', 'update')->name('update'); // Done
            Route::post('/{id}/update-password/', 'resetPassword')->name('updatePassword');
        });

        Route::get('/{id}/show-customer-visits', 'showMyVisits')->name('showMyVisits');

        Route::get('/{id}/delete', 'destroy')->name('destroy')->middleware('can:delete customer'); // Done

        Route::get('/{customer}/get-info', 'getCustomerInfo')->middleware('can:show customer')->name('getCustomerInfo');

    });

    // Cars Section
    Route::controller(App\Http\Controllers\CarController::class)->name('car.')->prefix('cars')->group(function ()
    {
        Route::get('show-all', 'showAll')->name('showAll');

        Route::get('store-car-names-in-db', 'UpdateCarsFromAPIToDB')->name('StoreCarsFromAPIToDB')->middleware('can:update cars');

        Route::get('/live_search/action', 'searchCar')->name('liveSearch');

        Route::get('/model', 'getCarModels')->name('getCarModels');

        Route::get('/specs', 'getCarSpecs')->name('getCarSpecs');

    });


    // Custom Cars Section
    Route::controller(App\Http\Controllers\CustomerCarInfoController::class)->name('car.')->prefix('cars')->group(function ()
    {
        Route::get('/car/customer', 'getCustomerCar')->name('getCustomerCar');

        Route::middleware('can:add customer car')->group(function () {
            Route::get('/add-car-to-customer/{cid}', 'createCustomerCar')->name('addToCustomer');

            Route::post('/store-car-to-customer/', 'storeCustomerCar')->name('storeToCustomer');
        });

        Route::get('/{cid}/{model_id}/delete', 'destroy')->name('destroy')->middleware('can:delete customer car'); // Done

    });


    // Visit Section
    Route::controller(App\Http\Controllers\VisitController::class)->name('visit.')->prefix('visits')->group(function ()
    {
        Route::get('show-all', 'index')->name('showAll');

        Route::middleware('can:create visit')->group(function () {
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
        });

        Route::middleware('can:edit visit')->group(function () {
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::post('/{id}/update', 'update')->name('update');
        });

        Route::get('customer-visits', 'getCustomerVisits')->name('getCustomerVisits');

        Route::get('/live_search/action', 'searchVisit')->name('liveSearch');

        Route::get('/{id}/delete', 'destroy')->name('destroy')->middleware('can:delete visit'); // Done
    });

    // Feedback Section
    Route::controller(App\Http\Controllers\FeedbackController::class)->name('feed.')->prefix('feedbacks')->group(function ()
    {
        Route::get('show-all', 'index')->name('showAll');

        Route::group(['middleware' => ['can:accept feedback']], function () {
            Route::get('accept-feedback', 'acceptFeed')->name('show_accept');
            Route::get('{feedback}/accept', 'accept')->name('accept');
        });

        Route::group(['middleware' => ['can:create feedback']], function () {
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
        });

        Route::get('/{feedback}/delete', 'destroy')->name('destroy')->middleware('can:delete feedback'); // Done

    });

    // Messages Section
    Route::controller(App\Http\Controllers\ChatController::class)->name('chats.')->prefix('chats')->group(function ()
    {
        Route::get('/', 'index')->name('messages');
        Route::get('/store/msg/{user}/{customer}', 'store')->name('store.msg');
        Route::get('/get/msg/{user}/{customer}', 'getLiveMessages')->name('get.msg');
    });

});
