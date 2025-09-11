<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ContactPolarTravelerBanner;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class ContactPolarTravelerBannerApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = ContactPolarTravelerBanner::select(
            'id',
            'header',
            'title',
            'image',
            'alt_tag'
        )->get();

        $data->map(function ($item) {
        $item->image = asset($item->image);
        return $item;
        });
        return $this->success($data, 'Success', 200);
    }
}
