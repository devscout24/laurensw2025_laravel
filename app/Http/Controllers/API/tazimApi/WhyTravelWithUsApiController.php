<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\WhyTravelWithUs;

class WhyTravelWithUsApiController extends Controller
{
    public function index()
    {
        $data = WhyTravelWithUs::all();

        if ($data->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'Unique Features data not found.',
                'data'    => [],
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Unique Features data fetched successfully.',
            'data'    => $data,
        ], 200);
    }
}
