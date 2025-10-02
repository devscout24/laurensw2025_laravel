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
        $data = NaturePageMetaTag::with('language')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'title'       => $item->title,
                    'description' => $item->description,
                    'lang_id'     => $item->lang_id,
                    'language'    => $item->language ? $item->language->name : null,
                ];
            });

        return $this->success($data, 'Success', 200);
    }
}
