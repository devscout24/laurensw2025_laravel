<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\TermCondtPageMetaTag;
use App\Traits\apiresponse;

class TermCondtPageMetaTagApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = TermCondtPageMetaTag::select(
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
