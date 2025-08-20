<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GetInTouchApiController extends Controller
{
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

        GetInTouch::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Your message has been sent successfully.',
        ]);
    }
}
