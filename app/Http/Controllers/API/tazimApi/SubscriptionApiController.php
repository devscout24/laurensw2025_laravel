<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Traits\apiresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SubscriptionApiController extends Controller
{
    use apiresponse;
    public function subscribe(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|unique:subscriptions,email',
                ],
                [
                    'email.unique' => 'You are already subscribed.',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(), // show single error
                    'errors'  => $validator->errors(),          // all errors (optional)
                ], 422);
            }

            // Save or update subscription
            $subscription = Subscription::updateOrCreate(
                ['email' => $request->email],
            );

            return $this->success($subscription, 'Subscribed successfully', 201);

        } catch (\Exception $e) {
            Log::error('Subscription failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while subscribing. ' . $e->getMessage(),
            ], 500);
        }
    }
}
