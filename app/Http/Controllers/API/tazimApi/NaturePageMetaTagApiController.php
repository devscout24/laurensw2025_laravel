<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\NaturePageMetaTag;
use App\Traits\apiresponse;

class NaturePageMetaTagApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = NaturePageMetaTag::select(
            'id',
            'title',
            'description',
            'language_code'
        )
            ->latest()
            ->limit(2)
            ->get();

        return $this->success($data, 'Success', 200);
    }
}
