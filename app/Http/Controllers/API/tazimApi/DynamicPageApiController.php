<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Traits\apiresponse;

class DynamicPageApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = DynamicPage::where('status', 'active')->select(
            'id',
            'page_title',
            'page_slug',
            'page_content'
        )->get();
        return $this->success($data, 'Success', 200);
    }

    public function show($slug)
    {
        $data = DynamicPage::where('status', 'active')->where('page_slug', $slug)->select(
            'id',
            'page_title',
            'page_slug',
            'page_content'
        )->first();

        if (! $data) {
            return response()->json([
                'success' => false,
                'message' => 'Dynamic Page not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
