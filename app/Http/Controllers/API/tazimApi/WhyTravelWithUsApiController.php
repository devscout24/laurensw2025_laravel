<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\WhyTravelWithUs;
use App\Models\WhyTrvlWithUsHead;
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

    public function header()
    {
        $data = WhyTrvlWithUsHead::select('id', 'header', 'title')->find(1);

        if (!$data) {
            return $this->error('Data not found', 404);
        }

        return $this->success($data, 'Success', 200);
    }
}
