<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OtpSend;
use App\Models\User;
use App\Traits\apiresponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    use apiresponse;

    public function create(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]
        );

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Error in Validation', 422);
        }


        // Create the user
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
        ]);

        $user->assignRole('user');

        // Attempt token-based login (JWT)
        $credentials = $request->only('email', 'password');
        $token = Auth::guard('api')->attempt($credentials);

        if (!$token) {
            return $this->error([], 'Registration successful but token generation failed.', 500);
        }

        // Format user data
        $userData = [
            'id'     => $user->id,
            'token'  => $token,
            'name'   => $user->name,
            'email'  => $user->email,
            'avatar' => asset($user->avatar == null ? 'user.png' : $user->avatar),
        ];

        return $this->success($userData, 'Registration and login successful', 200);
    }

    public function login(Request $request)
    {
        // Validate request inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Attempt login with email and password
        $credentials = $request->only('email', 'password');
        $token = Auth::guard('api')->attempt($credentials);

        // Return error if credentials are invalid
        if (!$token) {
            return $this->error([], 'Hmm, that didn’t work. Double-check your login details', 401);
        }

        // Retrieve authenticated user
        $user = Auth::guard('api')->user();

        // Update last login timestamp
        $user->save();

        // Format user data
        $userData = [
            'id'     => $user->id,
            'token'  => $token,
            'name'   => $user->name,
            'email'  => $user->email,
            'avatar' => asset($user->avatar == null ? 'user.png' : $user->avatar),
        ];


        return $this->success($userData, 'Login Successfull', 200);
    }


    public function logout()
    {
        try {
            // Get token from request
            $token = JWTAuth::getToken();

            if (!$token) {
                return $this->error([], 'Token not provided', 401);
            }

            // Invalidate token
            JWTAuth::invalidate($token);

            return $this->success([], 'Successfully logged out', 200);
        } catch (JWTException $e) {
            return $this->error([], 'Failed to logout. ' . $e->getMessage(), 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        // Validate incoming email
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error([], 'User with this email does not exist.', 404);
        }

        // Generate OTP and expiry
        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(15);

        // Save OTP and expiry to user
        $user->update([
            'otp' => $otp,
            'otp_expired_at' => $expiresAt,
        ]);

        // Send OTP via email
        Mail::to($user->email)->send(new OtpSend($otp));

        // Return success response (without exposing OTP in production)
        return $this->success([
            'email' => $user->email,
            'expires_at' => $expiresAt,
        ], 'OTP sent successfully.', 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required||min:6',
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        if (!$user) {
            return $this->error([], 'Invalid otp', 400);
        } else if ($user->otp_expired_at < Carbon::now()) {

            $user->otp = null;
            $user->otp_expired_at = null;
            $user->save();

            return $this->error([], 'OTP expired', 400);
        }

        $user->otp_verified_at                 = Carbon::now();
        $user->password_reset_token            = Str::random(64);
        $user->password_reset_token_expires_at = Carbon::now()->addMinutes(15);
        $user->save();

        return $this->success([
            'email' => $user->email,
            'reset_token' => $user->password_reset_token,
        ], 'OTP verified successfully', 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'       => 'required|email',
            'password'    => 'required|string|min:1|confirmed',
            'reset_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Error in Validation', 422);
        }

        $user = User::where('email', $request->email)
            ->where('password_reset_token', $request->reset_token)
            ->first();

        if (!$user) {
            return $this->error([], 'Invalid token or email.', 400);
        }

        if ($user->password_reset_token_expires_at < Carbon::now()) {
            return $this->error([], 'Token expired.', 400);
        }

        $user->password = bcrypt($request->password);



        // Attempt login with email and password
        $credentials = $request->only('email', 'password');
        Auth::guard('api')->attempt($credentials);

        // Format user data
        $userData = [
            'id'            => $user->id,
            'token'         => $user->password_reset_token,
            'name'          => $user->name == null ? 'User_name_' . uniqid() : $user->name,
            'email'         => $user->email,
            'username'      => $user->username,
            'profile_photo' => asset($user->profile_photo == null ? 'user.png' : $user->profile_photo),
        ];

        // Invalidate token after use
        $user->password_reset_token = null;
        $user->password_reset_token_expires_at = null;
        $user->save();



        return $this->success($userData, 'Login Successfull', 200);
    }

    public function redirect()
    {
        $data['url'] = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

        return $this->success($data, 'Login Successfull', 200);
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(24)),
                    'google_id' => $googleUser->getId(),
                ]
            );

            Auth::guard('api')->login($user);
            $token = Auth::guard('api')->fromUser($user);

            // Redirect to React frontend with token
            $frontendUrl = config('app.frontend_url') ?? 'http://localhost:3000';

            return redirect()->away($frontendUrl . '/google-success?token=' . $token);
        } catch (\Exception $e) {
            // Optionally redirect to error page or React route with error message
            return redirect()->away('http://localhost:3000/login?error=' . urlencode($e->getMessage()));
        }
    }
}
