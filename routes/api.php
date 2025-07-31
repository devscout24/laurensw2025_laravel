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
    Route::post('login', 'login');
    Route::post('register', 'register');

    // Resend Otp
    Route::post('resend-otp', 'resendOtp');

    // Forget Password
    Route::post('forget-password', 'forgetPassword');
    Route::post('verify-otp-password', 'varifyOtpWithOutAuth');
    Route::post('reset-password', 'resetPassword');

    // Google Login
    Route::post('google/login', 'googleLogin');
});

