<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\UniqueFeatures;
use App\Models\WhatMakesUsDiffHead;
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

    public function header()
    {
        $data = WhatMakesUsDiffHead::select('id', 'header', 'title')->find(1);

        if (!$data) {
            return $this->error('Data not found', 404);
        }

        return $this->success($data, 'Success', 200);
    }
}
