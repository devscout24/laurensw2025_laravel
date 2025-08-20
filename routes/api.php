<?php

use App\Http\Controllers\Api\backend\Auth;
use App\Http\Controllers\API\CommunityHubController;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\UserController;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Route;



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


require __DIR__ . '/tazimApi.php';
