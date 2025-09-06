<?php
namespace App\Http\Controllers\Web\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileSettingController extends Controller
{

    public function index(Request $request)
    {

        return view('backend.layout.setting.profileSettings');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email'    => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ], [
            'name.required'     => 'The name field is required.',
            'name.string'       => 'The name must be a valid string.',
            'name.max'          => 'The name must not exceed 255 characters.',

            'username.required' => 'The username field is required.',
            'username.string'   => 'The username must be a valid string.',
            'username.max'      => 'The username must not exceed 255 characters.',
            'username.unique'   => 'The username has already been taken.',

            'email.required'    => 'The email field is required.',
            'email.string'      => 'The email must be a valid string.',
            'email.email'       => 'Please enter a valid email address.',
            'email.max'         => 'The email must not exceed 255 characters.',
            'email.unique'      => 'The email address has already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => $validator->errors()->first(),
                'type'  => 'profile',
            ]);
        }

        try {
            $data = $request->all();

            User::find(Auth::id())->update($data);

            flash()->success('Profile updated successfully.');

            return redirect()->back();
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function updatePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'password'     => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => $validator->errors()->first(),
                'type'  => 'password',
            ]);
        }

        // dd($validatedData);

        try {

            if (! Hash::check($request->old_password, Auth::user()->password)) {
                throw new Exception('Old password does not match.');
            }

            $user           = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();

            flash()->success('Password updated successfully.');
            return redirect()->route('profile');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
    }

    // public function updateProfilePicture(Request $request)
    // {
    //     $request->validate([
    //         'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     try {
    //         $user = User::find(Auth::id());

    //         if ($request->hasFile('profile_picture')) {

    //             if (file_exists($user->avatar) && $user->avatar != 'user.png') {
    //                 unlink($user->avatar);
    //             }

    //             $path = Service::fileUpload($request->file('profile_picture'), 'profile_pictures/admins/');
    //             $user->avatar = $path;
    //             $user->save();

    //             $imageUrl = asset($user->avatar); // Generate the URL of the uploaded image

    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Profile picture updated successfully.',
    //                 'image_url' => $imageUrl, // Send the image URL to the frontend
    //             ], 200);
    //         }

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No file uploaded.',
    //         ], 400);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $user = User::find(Auth::id());

            if ($request->hasFile('profile_picture')) {

                // Delete old avatar if exists and not default
                if (! empty($user->avatar) && file_exists(public_path($user->avatar)) && $user->avatar != 'user.png') {
                    unlink(public_path($user->avatar));
                }

                // Define the upload path
                $uploadPath = public_path('profile_pictures/admins');

                // Create directory if it doesn't exist
                if (! file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                // Fix permissions if needed
                if (! is_writable($uploadPath)) {
                    chmod($uploadPath, 0775);
                }

                // Handle file upload
                $file     = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);

                // Save path in DB
                $user->avatar = 'profile_pictures/admins/' . $filename;
                $user->save();

                $imageUrl = asset($user->avatar); // Generate the URL of the uploaded image

                return response()->json([
                    'success'   => true,
                    'message'   => 'Profile picture updated successfully.',
                    'image_url' => $imageUrl,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded.',
            ], 400);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkusername(Request $request)
    {
        $input = $request->input('input');

        $currentUserId = Auth::id();

        $exists = User::where('username', $input)
            ->where('id', '!=', $currentUserId)
            ->exists();

        return response()->json([
            'exists' => $exists,
            'input'  => $input,
        ]);
    }

}
