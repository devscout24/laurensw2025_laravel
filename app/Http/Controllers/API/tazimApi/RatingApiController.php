<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\Rating;

class RatingApiController extends Controller
{
    public function index()
    {
        $data = Rating::all();
        return response()->json($data);
    }

    public function calculate()
    {
        $ratings = Rating::all();
        $count   = $ratings->count();

        if ($count === 0) {
            return response()->json([
                'average' => 0,
                'count'   => 0,
                'message' => 'No ratings available.',
            ]);
        }

        $total   = $ratings->sum('rating');
        $average = round($total / $count, 2); // Rounded to 2 decimal places

        return response()->json([
            'average' => $average,
            'count'   => $count,
        ]);
    }

}
