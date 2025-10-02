<?php

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\backend\Auth;
use App\Http\Controllers\API\PriceWiseSort;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FooterController;
use App\Http\Controllers\TripsTwoControllerApi;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\BookingsTwoController;
use App\Http\Controllers\API\SocialLoginController;
use App\Http\Controllers\API\SocialmediaController;
use App\Http\Controllers\API\CommunityHubController;
use App\Http\Controllers\API\PriceWiseSortController;
use App\Http\Controllers\API\HurtigrutenApiController;
use App\Http\Controllers\API\CruiseBookingControllerApi;
use App\Http\Controllers\API\TourListsDetailsController;
use App\Http\Controllers\API\AllTripApiDataGetController;
use App\Http\Controllers\API\tazimApi\SeoTitleApiController;
use App\Http\Controllers\Web\backend\CruiseBookingController;
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

//Continue with google and facebook login
Route::post('/social/login', [SocialLoginController::class, 'SocialLogin']);

// Routes for Heritage-expeditions Trips and Poseidons (Cruise)
Route::controller(TourListsDetailsController::class)->group(function () {
    Route::get('/api/one', 'getApiOne'); // for testing
    Route::get('/trips/retrive', 'getTrips');
    Route::get('/trips/{id}', 'getTripsDetails');
    //cruise lists
    Route::get('/cruise/list/retrive', 'getCruiseLists');
    Route::get('/cruise/{id}', 'getCruiseDetails');
});

//Routes for Oceanwide-Expeditions Trips (trips twos)
Route::controller(TripsTwoControllerApi::class)->group(function () {
    Route::get('/trips/two/retrive', 'index');
    Route::get('/trips/two/{id}', 'showDetails');
});

//Route for social media
Route::controller(SocialmediaController::class)->group(function () {
    Route::get('/social/media/retrive', 'index');
});

//Route for Footer text
Route::controller(FooterController::class)->group(function () {
    Route::get('/footer/text/retrive', 'index');
    Route::get('/logo/retrive', 'logoRetrive');
});

Route::controller(PriceWiseSortController::class)->group(function () {
    Route::get('/amount/sort', 'sorting');
});

Route::controller(AllTripApiDataGetController::class)->group(function () {
    Route::get('/all/trips/lists', 'getAllTripsData');
});


Route::controller(HurtigrutenApiController::class)->group(function () {
    //Test APi for see the data from API
    Route::get('/hurtigruten/trips', 'getAllHurtigrutenData');
});



/**
 * With JWT Authentication
 */
Route::middleware('auth:api')->group(function () {
    //Routes for Oceanwide-Expeditions Trips (trips twos) Booking
    Route::controller(BookingsTwoController::class)->group(function () {
        Route::post('/bookings-two/store', 'store');
        Route::get('/bookings/retrive', 'statusWiseBookingRetrive');
    });

    // Routes for Heritage-expeditions Trips Bookings
    Route::controller(BookingTripApiController::class)->group(function () {
        Route::post('/bookings/trip/store', 'store');
    });

    //Poseidons (Cruise/ships) Bookings
    Route::controller(CruiseBookingControllerApi::class)->group(function () {
        Route::post('/bookings/cruise/store', 'store');
    });
});


require __DIR__ . '/tazimApi.php';
