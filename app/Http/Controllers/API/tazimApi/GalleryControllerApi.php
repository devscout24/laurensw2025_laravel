<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryHead;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class GalleryControllerApi extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = Gallery::select(
            'id',
            'image',
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });
        return $this->success($data, 'Success', 200);
    }

    use apiresponse;
    public function header()
    {
        $data = GalleryHead::select(
            'id',
            'header'
        )->get();

        return $this->success($data, 'Success', 200);
    }
}
