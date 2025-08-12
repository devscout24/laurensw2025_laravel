<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\DynamicTripButton;

class DynamicTripButtonApiController extends Controller
{
    public function index()
    {
        $data = DynamicTripButton::all();

        if (! $data) {
            return response()->json([
                'status'  => false,
                'message' => 'data not found.',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'data fetched successfully.',
            'data'    => $data,
        ], 200);
    }
}
