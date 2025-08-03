<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\PeopleBehindTrip;
use Illuminate\Http\Request;

class PeopleBehindTripApiController extends Controller
{
        public function index()
    {
        $data = PeopleBehindTrip::all();

        if (! $data) {
            return response()->json([
                'status'  => false,
                'message' => 'People behind trip data not found.',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'People behind trip data fetched successfully.',
            'data'    => $data,
        ], 200);
    }
}
