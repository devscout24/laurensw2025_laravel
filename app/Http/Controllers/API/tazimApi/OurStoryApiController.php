<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\OurStory;
use App\Traits\apiresponse;

class OurStoryApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = OurStory::find(1)->select(
            'id',
            'header',
            'title',
            'description',
            'image'
        )->get();

        $data->map(function ($item) {
        $item->image = asset($item->image);
        return $item;
        });
        
        return $this->success($data, 'Success', 200);
    }
}
