<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ExploreFinnishWildernessBanner;
use App\Traits\apiresponse;

class ExploreFinnishWildernessBannerApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = ExploreFinnishWildernessBanner::select(
            'id',
            'header',
            'title',
            'image',
            'experience',
            'alt_tag'
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });
        return $this->success($data, 'Success', 200);
    }
}
