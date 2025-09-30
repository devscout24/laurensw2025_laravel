<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ShipPageMetaTag;
use App\Traits\apiresponse;

class ShipPageMetaTagApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = ShipPageMetaTag::select(
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
