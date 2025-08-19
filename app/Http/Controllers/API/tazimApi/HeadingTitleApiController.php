<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\HeadingTitle;
use App\Traits\apiresponse;

class HeadingTitleApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = HeadingTitle::select(
            'id',
            'heading',
            'title',
            'description'
        )->get();

        return $this->success($data, 'Success', 200);
    }

}
