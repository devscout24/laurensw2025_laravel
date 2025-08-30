<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\RatingHead;
use App\Traits\apiresponse;

class RatingApiController extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = Rating::latest()->get();

        $data = $data->map(function ($item) {
            return [
                'id'      => $item->id,
                'name'    => $item->name,
                'email'   => $item->email,
                'rating'  => $item->rating,
                'comment' => $item->comment,
                'image'   => asset($item->image),
            ];
        });

        return $this->success($data, 'Fetch Successfull', 200);
    }

    public function header()
    {
        $data = RatingHead::select('id', 'header', 'title')->find(1);

        if (! $data) {
            return $this->error('Data not found', 404);
        }

        return $this->success($data, 'Success', 200);
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
