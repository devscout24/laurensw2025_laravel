<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\UniqueFeatures;
use App\Traits\apiresponse;

class UniqueFeaturesApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = UniqueFeatures::select(
            'id',
            'heading',
            'image',
            'description'
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });
        return $this->success($data, 'Success', 200);
    }
}
