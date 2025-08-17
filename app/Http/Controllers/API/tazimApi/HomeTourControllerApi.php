<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Models\HomeTour;
use App\Traits\apiresponse;

class HomeTourControllerApi extends Controller
{
    use apiresponse;
    public function index()
    {
        $homeBanner = HomeTour::select(
            'id',
            'header',
            'title',
            'image',
            'duration',
            'ship',
            'price'
        )->get();
        return $this->success($homeBanner, 'Success', 200);
    }
}
