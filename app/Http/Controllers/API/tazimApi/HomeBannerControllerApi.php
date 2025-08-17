<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Traits\apiresponse;

class HomeBannerControllerApi extends Controller
{
    use apiresponse;
    public function index()
    {
        $homeBanner = HomeBanner::select(
            'id',
            'header',
            'title',
            'image',
            'experience',
            'happy_travelers',
            'number_of_destination'
        )->get();
        return $this->success($homeBanner, 'Success', 200);
    }
}
