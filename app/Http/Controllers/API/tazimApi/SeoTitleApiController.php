<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SeoTitle;
use App\Traits\apiresponse;

class SeoTitleApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = SeoTitle::select(
            'id',
            'title',
            'description'
        )->get();

        return $this->success($data, 'Success', 200);
    }
}
