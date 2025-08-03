<?php

use App\Http\Controllers\API\tazimApi\GetInTouchApiController;
use App\Http\Controllers\API\tazimApi\MissionApiController;
use App\Http\Controllers\API\tazimApi\OurStoryApiController;
use App\Http\Controllers\API\tazimApi\PeopleBehindTripApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
  Route::controller(MissionApiController::class)->group(function () {
        Route::post('/missionApi/index', 'index')->name('missionApi.index');
        // Route::post('/mission/login', 'login')->name('mission.login');
    });
  
    Route::controller(OurStoryApiController::class)->group(function () {
        Route::post('/ourstoryApi/index', 'index')->name('ourstoryApi.index');
    });
    
    Route::controller(PeopleBehindTripApiController::class)->group(function () {
        Route::post('/peopleBehindApi/index', 'index')->name('peopleBehindApi.index');
    });
    
});

Route::controller(GetInTouchApiController::class)->group(function () {
        Route::post('/getInTouchApi/store', 'store')->name('getInTouchApi.store');
    });
