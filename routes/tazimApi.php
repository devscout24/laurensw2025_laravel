<?php

use App\Http\Controllers\API\tazimApi\MissionApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
  Route::controller(MissionApiController::class)->group(function () {
        Route::post('/mission/index', 'index')->name('mission.index');
        // Route::post('/mission/login', 'login')->name('mission.login');
    });

});
