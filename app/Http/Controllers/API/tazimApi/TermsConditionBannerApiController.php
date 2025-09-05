<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\TermsConditionBanner;
use App\Traits\apiresponse;

class TermsConditionBannerApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = TermsConditionBanner::select(
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
