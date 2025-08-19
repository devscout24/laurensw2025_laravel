<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\DestinationWeCover;
use App\Traits\apiresponse;

class DestinationWeCoverApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = DestinationWeCover::select(
            'id',
            'image',
            'title',
            'url'
        )->get();

        $data->map(function ($item) {
        $item->image = asset($item->image);
        return $item;
        });
        return $this->success($data, 'Success', 200);
    }

}
