<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SeoTitle;

class SeoTitleApiController extends Controller
{
    public function index()
    {
        $data = SeoTitle::all();

        if(!$data) {
            return response()->json([
                'status' => false,
                'message' => 'No Data Found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Fetched Successfully',
            'data' => $data
        ]);
    }

}
