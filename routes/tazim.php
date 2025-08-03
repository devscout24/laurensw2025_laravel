<?php

use App\Http\Controllers\Web\backend\tazim\GetInTouchController;
use App\Http\Controllers\Web\backend\tazim\PeopleBehindTripController;
use App\Http\Controllers\Web\backend\tazim\MissionController;
use App\Http\Controllers\Web\backend\tazim\OurStoryController;
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
        Route::get('/peopleBehind/index', 'index')->name('peopleBehind.list');
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

});
