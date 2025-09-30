<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SeoTitle;
use App\Traits\apiresponse;

class SeoTitleApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = SeoTitle::with('language') // eager load the related language
            ->select('id', 'title', 'description', 'lang_id')
            ->get()
            ->map(function ($item) {
                return [
                    'id'            => $item->id,
                    'title'         => $item->title,
                    'description'   => $item->description,
                    'lang_id'       => $item->lang_id,
                    'language_name' => $item->language->name ?? 'N/A', // get name from relation
                ];
            });

        return $this->success($data, 'Success', 200);
    }
}
