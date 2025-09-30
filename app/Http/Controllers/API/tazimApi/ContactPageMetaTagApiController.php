<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ContactPageMetaTag;
use App\Traits\apiresponse;

class ContactPageMetaTagApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = ContactPageMetaTag::select(
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
