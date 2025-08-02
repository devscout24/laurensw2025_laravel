<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\OurMission;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissionApiController extends Controller
{
    public function index()
    {
        $mission = OurMission::find(1);

        if (! $mission) {
            return response()->json([
                'status'  => false,
                'message' => 'Mission data not found.',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Mission data fetched successfully.',
            'data'    => $mission,
        ], 200);
    }
}
