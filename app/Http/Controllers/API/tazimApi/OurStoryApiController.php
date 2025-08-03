<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\OurStory;

class OurStoryApiController extends Controller
{
    public function index()
    {
        $mission = OurStory::find(1);

        if (! $mission) {
            return response()->json([
                'status'  => false,
                'message' => 'Story data not found.',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Story data fetched successfully.',
            'data'    => $mission,
        ], 200);
    }
}
