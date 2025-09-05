<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ShipNtrTripExploreFinnishWildernessBanner;
use App\Traits\apiresponse;

class ShipNtrTripExploreFinnishWildernessBannerApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = ShipNtrTripExploreFinnishWildernessBanner::select(
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
    }
}
