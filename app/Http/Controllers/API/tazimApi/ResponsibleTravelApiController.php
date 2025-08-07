<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ResponsibleTravel;

class ResponsibleTravelApiController extends Controller
{
    public function index()
    {
        $data = ResponsibleTravel::all();

        if ($data->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'Responsible Travel data not found.',
                'data'    => [],
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Responsible Travel data fetched successfully.',
            'data'    => $data,
        ], 200);
    }
}
