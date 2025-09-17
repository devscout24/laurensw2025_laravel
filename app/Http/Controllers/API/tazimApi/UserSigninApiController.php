<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\apiresponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserSigninApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = User::find('id');
        return response()->json($data);
    }

    public function register()
    {
        $validate = Validator::make(request()->all(), [
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'username'      => 'required|unique:users,username',
            'date_of_birth' => 'nullable|date',
            'phone'         => 'nullable',
            'address'       => 'nullable',
            'city'          => 'nullable',
            'country'       => 'nullable',
            'zipcode'       => 'nullable',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors(), 'Validation failed', 422);
        }

        // Handle avatar upload
        if (request()->hasFile('avatar')) {
            $avatarFile = request()->file('avatar');
            $avatarName = time() . '_' . $avatarFile->getClientOriginalName();
            $avatarPath = 'backend/images/users/' . $avatarName;

            $avatarFile->move(public_path('backend/images/users'), $avatarName);
        } else {
            $avatarPath = 'backend/images/default-user.png';
        }

        $user = User::create([
            'name'          => request('name'),
            'email'         => request('email'),
            'avatar'        => $avatarPath,
            'username'      => request('username'),
            'phone'         => request('phone'),
            'date_of_birth' => request('date_of_birth'),
            'address'       => request('address'),
            'city'          => request('city'),
            'country'       => request('country'),
            'zipcode'       => request('zipcode'),
            'password'      => bcrypt(request('password')),
        ]);

        // Build custom response (only specific fields)
        $result = [
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'username'      => $user->username,
            'phone'         => $user->phone,
            'date_of_birth' => $user->date_of_birth,
            'avatar'        => asset($user->avatar),
        ];

        return $this->success($result, 'User created successfully', 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = JWTAuth::fromUser($user);
        $ttl   = config('jwt.ttl') * 60; // in seconds

        return response()->json([
            'status'     => true,
            'message'    => 'Login successful',
            'token'      => $token,
            // 'token_type' => 'bearer',
            'expires_in' => $ttl,
            'user'       => [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'username' => $user->username,
                'avatar'   => asset($user->avatar ?? 'backend/images/default-user.png'),
            ],
        ]);
    }

    public function logout(Request $request)
    {
        try {
            // Invalidate the token
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status'  => true,
                'message' => 'Successfully logged out',
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to logout, token invalid or not provided',
            ], 401);
        }
    }

    public function edit()
    {
        try {
            $user = User::findOrFail(auth()->id());

            if (! $user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found',
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'message' => 'User data fetched successfully',
                'data'    => [
                    'id'            => $user->id,
                    'name'          => $user->name,
                    'username'      => $user->username,
                    'email'         => $user->email,
                    'avatar'        => asset($user->avatar),
                    'phone'         => $user->phone,
                    'date_of_birth' => $user->date_of_birth,
                    'address'       => $user->address,
                    'city'          => $user->city,
                    'zipcode'       => $user->zipcode,
                    'country'       => $user->country,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch user data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::findOrFail(auth()->id()); // Authenticated user

            $validator = Validator::make($request->all(), [
                'name'          => 'nullable|string|max:255',
                'username'      => 'nullable|string|unique:users,username,' . $user->id,
                'email'         => 'nullable|email|unique:users,email,' . $user->id,
                'password'      => 'nullable|string|min:6',
                'date_of_birth' => 'nullable|date',
                'phone'         => 'nullable|string|unique:users,phone,' . $user->id,
                'address'       => 'nullable|string|max:255',
                'city'          => 'nullable|string|max:100',
                'zipcode'       => 'nullable|string|max:20',
                'country'       => 'nullable|string|max:100',
                'avatar'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 'Validation failed', 422);
            }

            // Handle avatar
            if ($request->hasFile('avatar')) {
                if (
                    $user->avatar &&
                    file_exists(public_path($user->avatar)) &&
                    $user->avatar !== 'backend/images/default-user.png'
                ) {
                    unlink(public_path($user->avatar));
                }

                $avatar     = $request->file('avatar');
                $avatarName = time() . '_' . $avatar->getClientOriginalName();
                $avatarPath = 'backend/images/users/' . $avatarName;
                $avatar->move(public_path('backend/images/users'), $avatarName);

                $user->avatar = $avatarPath;
            }

            // Update fields
            $user->name          = $request->name ?? $user->name;
            $user->username      = $request->username ?? $user->username;
            $user->email         = $request->email ?? $user->email;
            $user->date_of_birth = $request->date_of_birth ?? $user->date_of_birth;
            $user->phone         = $request->phone ?? $user->phone;
            $user->address       = $request->address ?? $user->address;
            $user->city          = $request->city ?? $user->city;
            $user->zipcode       = $request->zipcode ?? $user->zipcode;
            $user->country       = $request->country ?? $user->country;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Custom response fields
            $result = [
                'id'            => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'username'      => $user->username,
                'phone'         => $user->phone,
                'date_of_birth' => $user->date_of_birth,
                'avatar'        => asset($user->avatar),
            ];

            return $this->success($result, 'User profile updated successfully', 200);

        } catch (\Exception $e) {
            return $this->error([], 'Update failed: ' . $e->getMessage(), 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed', // new_password_confirmation expected in request
        ]);
        //  dd($request->all());

        $user = auth()->guard('api')->user();

        // Check old password match
        if (! Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Old password does not match.',
            ], 422);
        }

        // Check new password is different from old
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'New password must be different from the old password.',
            ], 422);
        }

        // Update password
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Password updated successfully.',
        ]);
    }

    public function delete()
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not authenticated.',
            ], 401);
        }

        DB::beginTransaction();

        try {
            $user->status = 'inactive';
            $user->save();

            $user->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'User deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Delete failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $user = User::where('email', $request->email)->first();

            $otp                  = rand(100000, 999999);
            $user->otp            = $otp;
            $user->otp_expired_at = Carbon::now()->addMinutes(5); // OTP valid for 5 mins
            $user->save();

            Mail::raw("Your password reset OTP is: {$otp}", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Password Reset OTP');
            });

            return response()->json([
                'status'  => true,
                'message' => 'OTP sent to your email. It is valid for 5 minutes.',
                'otp'     => $user->otp,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to send OTP. Please try again later.',
                'error'   => $e->getMessage(), // 🔹 remove or log in production
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp'   => 'required|digits:6',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! $user->otp || $user->otp != $request->otp) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid OTP.',
                ], 422);
            }

            if (Carbon::now()->greaterThan($user->otp_expired_at)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'OTP has expired.',
                ], 422);
            }

            $user->otp                             = null;
            $user->otp_expired_at                  = null;
            $user->password_reset_token            = Str::random(64);
            $user->password_reset_token_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            return response()->json([
                'status'      => true,
                'message'     => 'OTP verified. You can now reset your password.',
                'reset_token' => $user->password_reset_token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again later.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function forgetResetPass(Request $request)
    {
        try {
            $request->validate([
                'email'        => 'nullable|email|exists:users,email',
                'new_password' => 'required|string|min:6|confirmed', // looks for new_password_confirmation
            ]);

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                return Helper::jsonErrorResponse('No user found with this email address.', 404);
            }
            if ($user->password_reset_token === null || $user->password_reset_token_expires_at < now()) {
                return Helper::jsonErrorResponse('OTP verification failed or expired. Please request a new OTP.', 400);
            }

            $user->password                        = Hash::make($request->new_password);
            $user->password_reset_token            = null;
            $user->password_reset_token_expires_at = null;
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'Password reset successfully.',
            ]);
        } catch (\Exception $e) {
            // Catch any unexpected errors
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again later.',
                'error'   => $e->getMessage(), // 🔹 remove in production for security
            ], 500);
        }
    }

}
