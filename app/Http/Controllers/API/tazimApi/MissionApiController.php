<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\OurMission;
use App\Traits\apiresponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissionApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = OurMission::find(1)->select(
            'id',
            'header',
            'title',
            'description',
            'image_1',
            'image_2'
        )->get();

        $data->map(function ($item) {
        $item->image_1 = asset($item->image_1);
        return $item;
        });
        
        $data->map(function ($item) {
        $item->image_2 = asset($item->image_2);
        return $item;
        });

        return $this->success($data, 'Success', 200);
    }
}
