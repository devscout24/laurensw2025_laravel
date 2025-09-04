<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Mail\GetInTouchMail;
use App\Models\GetInTouch;
use App\Models\User;
use App\Traits\apiresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GetInTouchApiController extends Controller
{

    use apiresponse;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'phone'   => 'required|string|max:20',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:3000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $admin = User::where('is_admin', 1)->first();

        if (! $admin) {
            return response()->json([
                'status'  => false,
                'message' => 'No admin found.',
            ], 404);
        }

        $inserted = GetInTouch::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        try {
            Mail::to($admin->email)->queue(new GetInTouchMail($inserted));
            Log::info('Mail queued successfully for: ' . $admin->email);
        } catch (\Exception $e) {
            Log::error('Mail queue failed: ' . $e->getMessage());
        }

        // Re-query just the fields you want to return (like your DynamicTripButton example)
        $data = GetInTouch::select('id', 'name', 'email', 'phone', 'subject', 'message')
            ->where('id', $inserted->id)
            ->first();

        return $this->success($data, 'Success', 200);
    }

}
