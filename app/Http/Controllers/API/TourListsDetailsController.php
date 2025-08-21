<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;


class TourListsDetailsController extends Controller
{
    public function getApiOne(Request $request)
    {
        // Validation for query params
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
        ]);

        $page = $validated['page'] ?? 1;
        $perPage = $validated['per_page'] ?? 10;

        // API URL (no pagination, it returns all data)
        $url = "https://api.heritage-expeditions.com/v1/trips";

        // API call
        $response = Http::withHeaders([
            'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
            'Accept' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            // Convert all data into collection
            $data = collect($response->json());

            // Laravel internal pagination
            $paginated = new LengthAwarePaginator(
                $data->forPage($page, $perPage), // slice only needed items
                $data->count(),                 // total items
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return response()->json($paginated, 200);
        }

        return response()->json([
            'error' => 'Failed to fetch data',
            'status' => $response->status(),
            'message' => $response->body()
        ], $response->status());
    }
}
