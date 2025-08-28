<?php

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\backend\Auth;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\TripsTwoControllerApi;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\BookingsTwoController;
use App\Http\Controllers\API\CommunityHubController;
use App\Http\Controllers\API\CruiseBookingController;
use App\Http\Controllers\API\TourListsDetailsController;
use App\Http\Controllers\API\tazimApi\SeoTitleApiController;
use App\Http\Controllers\API\tazimApi\BookingTripApiController;



// Site Info
Route::get('/site/info', function () {
    $query = SystemSetting::query();

    $data = $query->first();

    return response()->json(['success' => true, 'data' => $data], 200);
});


Route::controller(UserAuthController::class)->group(function () {
    Route::post('/create-account', 'create');
    Route::post('/user-login', 'login');
    Route::post('/user-logout', 'logout');

    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/verify-otp', 'verifyOtp');
    Route::post('/reset-password', 'resetPassword');

    // Google Login Route
    Route::post('/auth/google/redirect', 'redirect');
    Route::get('/auth/google/callback', 'callback');
});

// Import into DB
Route::controller(TourListsDetailsController::class)->group(function () {
    Route::get('/api/one', 'getApiOne'); // for testing
    Route::get('/trips/retrive', 'getTrips');
    Route::get('/trips/{id}', 'getTripsDetails');
    //cruise lists
    Route::get('/cruise/list/retrive', 'getCruiseLists');
    Route::get('/cruise/{id}', 'getCruiseDetails');
});
Route::controller(TripsTwoControllerApi::class)->group(function () {
    Route::get('/trips/two/retrive', 'index');
    Route::get('/trips/two/{id}', 'showDetails');
});

/**
 * With JWT Authentication
 */
Route::middleware('auth:api')->group(function () {

    Route::controller(BookingsTwoController::class)->group(function () {
        Route::post('/bookings-two/store', 'store');
    });
    Route::controller(BookingTripApiController::class)->group(function () {
        Route::post('/bookings/trip/store', 'store');
    });
    Route::controller(CruiseBookingController::class)->group(function () {
        Route::post('/bookings/cruise/store', 'store');
    });



});


require __DIR__ . '/tazimApi.php';
