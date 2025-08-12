<?php

use App\Http\Controllers\Web\backend\tazim\DynamicTripButtonController;
use App\Http\Controllers\Web\backend\tazim\BookingTripController;
use App\Http\Controllers\Web\backend\tazim\DestinationWeCoverController;
use App\Http\Controllers\Web\backend\tazim\GetInTouchController;
use App\Http\Controllers\Web\backend\tazim\HeadingTitleController;
use App\Http\Controllers\Web\backend\tazim\PeopleBehindTripController;
use App\Http\Controllers\Web\backend\tazim\MissionController;
use App\Http\Controllers\Web\backend\tazim\OurStoryController;
use App\Http\Controllers\Web\backend\tazim\RatingController;
use App\Http\Controllers\Web\backend\tazim\ResponsibleTravelController;
use App\Http\Controllers\Web\backend\tazim\SeoTitleController;
use App\Http\Controllers\Web\backend\tazim\UniqueFeaturesController;
use App\Http\Controllers\Web\backend\tazim\WhyTravelWithUsController;
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
        Route::get('/rating/show/{id}', 'show')->name('rating.show');
        Route::get('/rating/edit/{id}', 'edit')->name('rating.edit');
        Route::post('/rating/update/{id}', 'update')->name('rating.update');
        Route::get('/rating/delete/{id}', 'delete')->name('rating.delete');
    });

    Route::controller(HeadingTitleController::class)->group(function () {
        Route::get('/headingTitle/index', 'index')->name('headingTitle.list');
        Route::get('/headingTitle/getData', 'getData')->name('headingTitle.getData');
        Route::get('/headingTitle/create', 'create')->name('headingTitle.create');
        Route::post('/headingTitle/store', 'store')->name('headingTitle.store');
        Route::get('/headingTitle/show/{id}', 'show')->name('headingTitle.show');
        Route::get('/headingTitle/edit/{id}', 'edit')->name('headingTitle.edit');
        Route::post('/headingTitle/update/{id}', 'update')->name('headingTitle.update');
        Route::get('/headingTitle/delete/{id}', 'delete')->name('headingTitle.delete');
    });

    Route::controller(DestinationWeCoverController::class)->group(function () {
        Route::get('/destinationCover/index', 'index')->name('destinationCover.list');
        Route::get('/destinationCover/getData', 'getData')->name('destinationCover.getData');
        Route::get('/destinationCover/create', 'create')->name('destinationCover.create');
        Route::post('/destinationCover/store', 'store')->name('destinationCover.store');
        Route::get('/destinationCover/show/{id}', 'show')->name('destinationCover.show');
        Route::get('/destinationCover/edit/{id}', 'edit')->name('destinationCover.edit');
        Route::post('/destinationCover/update/{id}', 'update')->name('destinationCover.update');
        Route::get('/destinationCover/delete/{id}', 'delete')->name('destinationCover.delete');
    });

    Route::controller(SeoTitleController::class)->group(function () {
        Route::get('/seoTitle/index', 'index')->name('seoTitle.list');
        Route::get('/seoTitle/getData', 'getData')->name('seoTitle.getData');
        Route::get('/seoTitle/create', 'create')->name('seoTitle.create');
        Route::post('/seoTitle/store', 'store')->name('seoTitle.store');
        Route::get('/seoTitle/show/{id}', 'show')->name('seoTitle.show');
        Route::get('/seoTitle/edit/{id}', 'edit')->name('seoTitle.edit');
        Route::post('/seoTitle/update/{id}', 'update')->name('seoTitle.update');
        Route::get('/seoTitle/delete/{id}', 'delete')->name('seoTitle.delete');
    });

    Route::controller(WhyTravelWithUsController::class)->group(function () {
        Route::get('/whyTravelWithUs/index', 'index')->name('whyTravelWithUs.list');
        Route::get('/whyTravelWithUs/getData', 'getData')->name('whyTravelWithUs.getData');
        Route::get('/whyTravelWithUs/create', 'create')->name('whyTravelWithUs.create');
        Route::post('/whyTravelWithUs/store', 'store')->name('whyTravelWithUs.store');
        Route::get('/whyTravelWithUs/show/{id}', 'show')->name('whyTravelWithUs.show');
        Route::get('/whyTravelWithUs/edit/{id}', 'edit')->name('whyTravelWithUs.edit');
        Route::post('/whyTravelWithUs/update/{id}', 'update')->name('whyTravelWithUs.update');
        Route::get('/whyTravelWithUs/delete/{id}', 'delete')->name('whyTravelWithUs.delete');
    });

    Route::controller(DynamicTripButtonController::class)->group(function () {
        Route::get('/dynamicTripButton/index', 'index')->name('dynamicTripButton.list');
        Route::get('/dynamicTripButton/getData', 'getData')->name('dynamicTripButton.getData');
        Route::get('/dynamicTripButton/create', 'create')->name('dynamicTripButton.create');
        Route::post('/dynamicTripButton/store', 'store')->name('dynamicTripButton.store');
        Route::get('/dynamicTripButton/show/{id}', 'show')->name('dynamicTripButton.show');
        Route::get('/dynamicTripButton/edit/{id}', 'edit')->name('dynamicTripButton.edit');
        Route::post('/dynamicTripButton/update/{id}', 'update')->name('dynamicTripButton.update');
        Route::get('/dynamicTripButton/delete/{id}', 'delete')->name('dynamicTripButton.delete');
    });

});
