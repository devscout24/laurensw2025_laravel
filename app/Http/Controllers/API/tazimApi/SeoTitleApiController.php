<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SeoTitle;
use App\Traits\apiresponse;
use Illuminate\Support\Facades\Http;


class SeoTitleApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = SeoTitle::select(
            'id',
            'title',
            'description'
        )->get();

        return $this->success($data, 'Success', 200);
    }


   public function getApiOne()
    {
        // API root URL
        $url = "https://api.heritage-expeditions.com/v1/trips";

        // API call
        $response = Http::withHeaders([
            'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
            'Accept' => 'application/json',
        ])->get($url);

        // response check
        if ($response->successful()) {
            $data = $response->json();
            return $this->success($data, 'Success', 200);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data',
                'status' => $response->status(),
                'message' => $response->body()
            ], $response->status());
        }
    }
}

