<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\NtrTripExploreFinnishWildernessBanner;
use App\Traits\apiresponse;

class NtrTripExploreFinnishWildernessBannerApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = NtrTripExploreFinnishWildernessBanner::select(
            'id',
            'header',
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
