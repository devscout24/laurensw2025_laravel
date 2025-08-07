<?php

use App\Http\Controllers\Web\backend\tazim\BookingTripController;
use App\Http\Controllers\Web\backend\tazim\GetInTouchController;
use App\Http\Controllers\Web\backend\tazim\PeopleBehindTripController;
use App\Http\Controllers\Web\backend\tazim\MissionController;
use App\Http\Controllers\Web\backend\tazim\OurStoryController;
use App\Http\Controllers\Web\backend\tazim\RatingController;
use App\Http\Controllers\Web\backend\tazim\ResponsibleTravelController;
use App\Http\Controllers\Web\backend\tazim\UniqueFeaturesController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::controller(MissionController::class)->group(function () {
        Route::get('/mission/create', 'create')->name('mission.create');
        Route::post('/mission/store', 'store')->name('mission.store');
    });

    Route::controller(OurStoryController::class)->group(function () {
        Route::get('/ourstory/create', 'create')->name('ourstory.create');
        Route::post('/ourstory/store', 'store')->name('ourstory.store');
    });
    
    Route::controller(PeopleBehindTripController::class)->group(function () {
        Route::get('/peopleBehind/create', 'index')->name('peopleBehind.list');
        Route::get('/peopleBehind/create', 'create')->name('peopleBehind.create');
        Route::get('/peopleBehind/getData', 'getData')->name('peopleBehind.getData');
        Route::post('/peopleBehind/store', 'store')->name('peopleBehind.store');
        Route::get('/peopleBehind/edit/{id}', 'edit')->name('peopleBehind.edit');
        Route::post('/peopleBehind/update/{id}', 'update')->name('peopleBehind.update');
        Route::get('/peopleBehind/delete/{id}', 'delete')->name('peopleBehind.delete');
    });

    Route::controller(GetInTouchController::class)->group(function () {
        Route::get('/getInTouch/index', 'index')->name('getInTouch.list');
        Route::get('/getInTouch/getData', 'getData')->name('getInTouch.getData');
        Route::get('/getInTouch/show/{id}', 'show')->name('getInTouch.show');
        Route::get('/getInTouch/delete/{id}', 'delete')->name('getInTouch.delete');
    });

    Route::controller(BookingTripController::class)->group(function () {
        Route::get('/bookingTrip/index', 'index')->name('bookingTrip.list');
        Route::get('/bookingTrip/getData', 'getData')->name('bookingTrip.getData');
        Route::get('/bookingTrip/show/{id}', 'show')->name('bookingTrip.show');
        Route::get('/bookingTrip/edit/{id}', 'edit')->name('bookingTrip.edit');
        Route::post('/bookingTrip/update/{id}', 'update')->name('bookingTrip.update');
        Route::get('/bookingTrip/delete/{id}', 'delete')->name('bookingTrip.delete');
    });
    
    Route::controller(UniqueFeaturesController::class)->group(function () {
        Route::get('/uniqueFeatures/index', 'index')->name('uniqueFeatures.list');
        Route::get('/uniqueFeatures/getData', 'getData')->name('uniqueFeatures.getData');
        Route::get('/uniqueFeatures/create', 'create')->name('uniqueFeatures.create');
        Route::post('/uniqueFeatures/store', 'store')->name('uniqueFeatures.store');
        Route::get('/uniqueFeatures/edit/{id}', 'edit')->name('uniqueFeatures.edit');
        Route::post('/uniqueFeatures/update/{id}', 'update')->name('uniqueFeatures.update');
        Route::get('/uniqueFeatures/delete/{id}', 'delete')->name('uniqueFeatures.delete');
    });

    Route::controller(ResponsibleTravelController::class)->group(function () {
        Route::get('/responsibleTravel/index', 'index')->name('responsibleTravel.list');
        Route::get('/responsibleTravel/getData', 'getData')->name('responsibleTravel.getData');
        Route::get('/responsibleTravel/create', 'create')->name('responsibleTravel.create');
        Route::post('/responsibleTravel/store', 'store')->name('responsibleTravel.store');
        Route::get('/responsibleTravel/edit/{id}', 'edit')->name('responsibleTravel.edit');
        Route::post('/responsibleTravel/update/{id}', 'update')->name('responsibleTravel.update');
        Route::get('/responsibleTravel/delete/{id}', 'delete')->name('responsibleTravel.delete');
    });

    Route::controller(RatingController::class)->group(function () {
        Route::get('/rating/index', 'index')->name('rating.list');
        Route::get('/rating/getData', 'getData')->name('rating.getData');
        Route::get('/rating/create', 'create')->name('rating.create');
        Route::post('/rating/store', 'store')->name('rating.store');
        Route::get('/rating/show', 'show')->name('rating.show');
        Route::get('/rating/edit/{id}', 'edit')->name('rating.edit');
        Route::post('/rating/update/{id}', 'update')->name('rating.update');
        Route::get('/rating/delete/{id}', 'delete')->name('rating.delete');
    });

});
