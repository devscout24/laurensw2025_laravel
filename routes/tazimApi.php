<?php

use App\Http\Controllers\API\tazimApi\BookingTripApiController;
use App\Http\Controllers\API\tazimApi\DestinationWeCoverApiController;
use App\Http\Controllers\API\tazimApi\GetInTouchApiController;
use App\Http\Controllers\API\tazimApi\HeadingTitleApiController;
use App\Http\Controllers\API\tazimApi\MissionApiController;
use App\Http\Controllers\API\tazimApi\OurStoryApiController;
use App\Http\Controllers\API\tazimApi\PeopleBehindTripApiController;
use App\Http\Controllers\API\tazimApi\RatingApiController;
use App\Http\Controllers\API\tazimApi\ResponsibleTravelApiController;
use App\Http\Controllers\API\tazimApi\SeoTitleApiController;
use App\Http\Controllers\API\tazimApi\UniqueFeaturesApiController;
use App\Http\Controllers\API\tazimApi\UserSigninApiController;
use App\Http\Controllers\API\tazimApi\WhyTravelWithUsApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::controller(MissionApiController::class)->group(function () {
        Route::get('/missionApi/index', 'index')->name('missionApi.index');
        // Route::post('/mission/login', 'login')->name('mission.login');
    });

    Route::controller(OurStoryApiController::class)->group(function () {
        Route::get('/ourstoryApi/index', 'index')->name('ourstoryApi.index');
    });

    Route::controller(PeopleBehindTripApiController::class)->group(function () {
        Route::get('/peopleBehindApi/index', 'index')->name('peopleBehindApi.index');
    });

    Route::controller(BookingTripApiController::class)->group(function () {
        Route::get('/bookingTripApi/index', 'index')->name('bookingTripApi.index');
        Route::post('/bookingTripApi/store', 'store')->name('bookingTripApi.store');
    });

    Route::controller(UserSigninApiController::class)->group(function () {
        Route::post('/userSigninApi/logout', 'logout')->name('userSigninApi.logout');
        Route::get('/userSigninApi/edit', 'edit')->name('userSigninApi.edit');
        Route::post('/userSigninApi/update', 'update')->name('userSigninApi.update');
        Route::post('/userSigninApi/resetPassword', 'resetPassword')->name('userSigninApi.resetPassword');
        Route::delete('/userSigninApi/delete', 'delete')->name('userSigninApi.delete');
    });

});

Route::controller(GetInTouchApiController::class)->group(function () {
    Route::post('/getInTouchApi/store', 'store')->name('getInTouchApi.store');
});

Route::controller(UserSigninApiController::class)->group(function () {
    Route::post('/userSigninApi/register', 'register')->name('userSigninApi.register');
    Route::post('/userSigninApi/login', 'login')->name('userSigninApi.login');
});

Route::controller(UniqueFeaturesApiController::class)->group(function () {
    Route::get('/uniqueFeaturesApi/index', 'index')->name('uniqueFeaturesApi.index');
});

Route::controller(ResponsibleTravelApiController::class)->group(function () {
    Route::get('/responsibleTravelApi/index', 'index')->name('responsibleTravelApi.index');
});

Route::controller(RatingApiController::class)->group(function () {
    Route::get('/ratingApi/index', 'index')->name('ratingApi.index');
    Route::get('/ratingApi/calculate', 'calculate')->name('ratingApi.calculate');
});

Route::controller(HeadingTitleApiController::class)->group(function () {
    Route::get('/headingTitleApi/index', 'index')->name('headingTitleApi.index');
});

Route::controller(DestinationWeCoverApiController::class)->group(function () {
    Route::get('/destinationCoverApi/index', 'index')->name('destinationCoverApi.index');
});

Route::controller(SeoTitleApiController::class)->group(function () {
    Route::get('/seoTitleApi/index', 'index')->name('seoTitleApi.index');
});

Route::controller(WhyTravelWithUsApiController::class)->group(function () {
    Route::get('/whyTravelWithUsapi/index', 'index')->name('whyTravelWithUsapi.index');
});
