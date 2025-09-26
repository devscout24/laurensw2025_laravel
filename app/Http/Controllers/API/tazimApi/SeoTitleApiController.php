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
        // $data = SeoTitle::select(
        //     'id',
        //     'title',
        //     'description',
        //     'language_code'

        // )->get();

        $data = SeoTitle::with('language') // eager load the related language
        ->select('id', 'title', 'description', 'language_code')
        ->get()
        ->map(function ($item) {
            return [
                'id'            => $item->id,
                'title'         => $item->title,
                'description'   => $item->description,
                'language_code' => $item->language_code,
                'language_name' => $item->language->name ?? 'N/A', // get name from relation
            ];
        });

        return $this->success($data, 'Success', 200);
    }
}
