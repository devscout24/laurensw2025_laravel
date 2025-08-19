<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\WhyTravelWithUs;
use App\Traits\apiresponse;

class WhyTravelWithUsApiController extends Controller
{
    use apiresponse;
    public function index1()
    {
        $data = WhyTravelWithUs::where('id', 1)->select(
            'id',
            'header',
            'title',
            'description1',
            'description2',
            'description3',
            'description4',
        )->get();
        return $this->success($data, 'Success', 200);
    }

    public function index2()
    {
        $data = WhyTravelWithUs::where('id', 2)->select(
            'id',
            'header',
            'title',
            'description1',
            'description2',
            'description3',
            'description4',
        )->get();
        return $this->success($data, 'Success', 200);
    }
}
