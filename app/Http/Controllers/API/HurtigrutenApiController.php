<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\apiresponse;

class HurtigrutenApiController extends Controller
{
    use apiresponse;

    public function getAllHurtigrutenData()
    {
        try {
            // 1. Get access token
            $authResponse = Http::post('https://partner-travelhx.eu.auth0.com/oauth/token', [
                'client_id'     => env('HURTI_CLIENT_ID'),
                'client_secret' => env('HURTI_CLIENT_SECRET'),
                'audience'      => 'https://partner.travelhx.com/api',
                'grant_type'    => 'client_credentials',
            ]);

            $data = $authResponse->json();
            if (!isset($data['access_token'])) {
                return response()->json(['status' => false, 'details' => $data], 401);
            }
            $token = $data['access_token'];

            // 2. Prepare base URL
            $baseUrl = "https://partner.travelhx.com/api/v2";

            // 3. Fetch all endpoints
            $packages   = Http::withToken($token)->get("$baseUrl/packages", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'market'    => 'no',
                'currency'  => 'sek',
                'take'      => 20,
            ])->json();

            $voyages    = Http::withToken($token)->get("$baseUrl/refdata/voyages", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'locale'    => 'nb-NO',
                'take'      => 20,
            ])->json();

            $ships      = Http::withToken($token)->get("$baseUrl/refdata/ships", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'locale'    => 'nb-NO',
            ])->json();

            $excursions = Http::withToken($token)->get("$baseUrl/refdata/excursions", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'locale'    => 'nb-NO',
            ])->json();

            $ports      = Http::withToken($token)->get("$baseUrl/refdata/ports", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
            ])->json();

            // Debug summary (how many records came from each endpoint)
            $summary = [
                'packages_total'   => $packages['total']   ?? count($packages['data'] ?? []),
                'voyages_total'    => $voyages['total']    ?? count($voyages['data'] ?? []),
                'ships_total'      => $ships['total']      ?? count($ships['data'] ?? []),
                'excursions_total' => $excursions['total'] ?? count($excursions['data'] ?? []),
                'ports_total'      => $ports['total']      ?? count($ports['data'] ?? []),
            ];

            // 4. Merge everything
            return $this->success([
                'message' => 'All Hurtigruten data retrieved successfully',
                'summary' => $summary, // Debug summary (how many records came from each endpoint)
                'data'    => [
                    'packages'   => $packages,
                    'voyages'    => $voyages,
                    'ships'      => $ships,
                    'excursions' => $excursions,
                    'ports'      => $ports,
                ]
            ]);
        } catch (\Exception $e) {
            return $this->error([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}

