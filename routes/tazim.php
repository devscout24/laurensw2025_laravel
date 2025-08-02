<?php

use App\Http\Controllers\Web\backend\tazim\MissionController;


use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::controller(MissionController::class)->group(function () {
        Route::get('/mission/create', 'create')->name('mission.create');
        Route::post('/mission/store', 'store')->name('mission.store');
    });



});
