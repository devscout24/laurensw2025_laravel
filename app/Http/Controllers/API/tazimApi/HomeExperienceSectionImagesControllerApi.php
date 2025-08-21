<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ExperienceSectionImageHeader;
use App\Models\HomeExperienceSectionImages;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class HomeExperienceSectionImagesControllerApi extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = HomeExperienceSectionImages::select(
            'id',
            'name',
            'image'
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }

    public function header()
    {
        $data = ExperienceSectionImageHeader::select('id', 'header', 'title')->find(1);

        if (!$data) {
            return $this->error('Data not found', 404);
        }

        return $this->success($data, 'Success', 200);
    }
}
