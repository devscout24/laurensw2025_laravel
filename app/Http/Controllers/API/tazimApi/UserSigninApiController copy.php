<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use App\Traits\apiresponse;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserSigninApiController extends Controller
{
    use apiresponse;

// Forgot Password API - send OTP to email
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::jsonErrorResponse('No user found with this email address.', 404);
        }

        // Generate a 6-digit reset token
        $token = rand(100000, 999999);

        // Store the token and expiry time in the database
        $user->password_reset_token = $token;
        $user->password_reset_token_expiry = now()->addMinutes(5);  // Token expires after 5 minutes
        $user->save();

        // Send token to the user's email (using Queue)
        Mail::to($user->email)->queue(new PasswordResetMail($token));

        return Helper::jsonResponse(true, 'Password reset OTP has been sent to your email.', 200, ['OTP' => $user->password_reset_token]);
    }



    // OTP Verification API - Verify OTP sent to email
    public function verifyOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::jsonErrorResponse('No user found with this email address.', 404);
        }

        // Check if the OTP matches
        if ($user->password_reset_token !== $request->otp) {
            return Helper::jsonErrorResponse('Invalid OTP.', 400);
        }

        // Check if the OTP has expired
        if ($user->password_reset_token_expiry < now()) {
            return Helper::jsonErrorResponse('OTP has expired.', 400);
        }

        // OTP is valid, proceed to allow password reset
        return Helper::jsonResponse(true, 'OTP verified successfully. You can now reset your password.', 200);
    }



    // Password Reset API - Reset user password
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Profile Update Validation failed', 422, $validator->errors()->toArray());
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::jsonErrorResponse('No user found with this email address.', 404);
        }

        // Check if OTP verification is done
        if ($user->password_reset_token === null || $user->password_reset_token_expiry < now()) {
            return Helper::jsonErrorResponse('OTP verification failed or expired. Please request a new OTP.', 400);
        }

        // If OTP is verified and not expired, proceed with password reset
        $user->password = Hash::make($request->password); // Hash the new password
        $user->password_reset_token = null; // Clear the token after password reset
        $user->password_reset_token_expiry = null; // Clear the expiry
        $user->save();

        return Helper::jsonResponse(true, 'Password has been successfully reset.', 200);
    }

    

}
