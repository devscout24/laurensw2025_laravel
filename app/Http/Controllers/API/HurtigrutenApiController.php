<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SimpleSwOTAService;
use App\Traits\apiresponse;
use Illuminate\Support\Facades\Http;

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
            if (! isset($data['access_token'])) {
                return response()->json(['status' => false, 'details' => $data], 401);
            }
            $token = $data['access_token'];

            // 2. Prepare base URL
            $baseUrl = "https://partner.travelhx.com/api/v2";

            // 3. Fetch all endpoints
            $packages = Http::withToken($token)->get("$baseUrl/packages", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'market'    => 'no',
                'currency'  => 'sek',
                'take'      => 20,
            ])->json();

            $voyages = Http::withToken($token)->get("$baseUrl/refdata/voyages", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'locale'    => 'nb-NO',
                'take'      => 20,
            ])->json();

            $ships = Http::withToken($token)->get("$baseUrl/refdata/ships", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'locale'    => 'nb-NO',
            ])->json();

            $excursions = Http::withToken($token)->get("$baseUrl/refdata/excursions", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
                'locale'    => 'nb-NO',
            ])->json();

            $ports = Http::withToken($token)->get("$baseUrl/refdata/ports", [
                'user_key'  => env('HURTI_USER_KEY'),
                'agency_id' => env('HURTI_AGENCY_ID'),
            ])->json();

            // Debug summary (how many records came from each endpoint)
            $summary = [
                'packages_total'   => $packages['total'] ?? count($packages['data'] ?? []),
                'voyages_total'    => $voyages['total'] ?? count($voyages['data'] ?? []),
                'ships_total'      => $ships['total'] ?? count($ships['data'] ?? []),
                'excursions_total' => $excursions['total'] ?? count($excursions['data'] ?? []),
                'ports_total'      => $ports['total'] ?? count($ports['data'] ?? []),
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
                ],
            ]);
        } catch (\Exception $e) {
            return $this->error([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // public function otaRequest(string $endpoint, string $xmlBody)
    // {
    //     try {
    //         // 1) Get ACCESS TOKEN
    //         $authResponse = Http::post('https://partner-travelhx.eu.auth0.com/oauth/token', [
    //             'client_id'     => env('HURTI_CLIENT_ID'),
    //             'client_secret' => env('HURTI_CLIENT_SECRET'),
    //             'audience'      => env('HURTI_OTA_AUDIENCE', 'https://bookings-dev.sw.travelhx.com'),
    //             'grant_type'    => 'client_credentials',
    //         ]);

    //         $authData = $authResponse->json();

    //         /* 👇 DEBUG HERE */
    //         Log::info('OTA TOKEN RESPONSE', $authData);

    //         if (empty($authData['access_token'])) {
    //             return $this->error([
    //                 'message' => 'Auth token generation failed',
    //                 'details' => $authData,
    //             ], 401);
    //         }

    //         $token = $authData['access_token'];

    //         // 2) Build full API URL
    //         // Note: OTA uses a different base path compared to your JSON REST v2 calls
    //         // (your example uses bookings-dev.sw.travelhx.com, adapt if needed)
    //         $baseOtaUrl = env('TRAVELHX_OTA_BASE_URL', 'https://bookings-dev.sw.travelhx.com/ota/rest');

    //         $url = rtrim($baseOtaUrl, '/') . '/' . $endpoint;

    //         // 3) Send XML request
    //         $response = Http::withToken($token)
    //             ->withHeaders([
    //                 'Content-Type' => 'application/xml',
    //                 'Accept'       => 'application/xml',
    //             ])
    //             ->send('POST', $url, [
    //                 'body' => $xmlBody,
    //             ]);

    //         // 4) Check success
    //         if (! $response->successful()) {
    //             return $this->error([
    //                 'message' => "OTA call failed: $endpoint",
    //                 'status'  => $response->status(),
    //                 'body'    => $response->body(),
    //             ], $response->status());
    //         }

    //         // 5) Return bytes
    //         return $this->success([
    //             'endpoint' => $endpoint,
    //             'raw_xml'  => $response->body(),
    //         ]);

    //     } catch (\Throwable $e) {
    //         return $this->error([
    //             'message' => 'Unexpected failure calling OTA',
    //             'error'   => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function otaPing()
    {
        $timestamp = now()->utc()->toIso8601String();

        $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <OTA_PingRQ xmlns="http://www.opentravel.org/OTA/2003/05"
                    Version="1.0"
                    TimeStamp="$timestamp">
            <EchoData>Laravel OTA Ping Test</EchoData>
        </OTA_PingRQ>
        XML;

        // return $this->otaRequest('OTA_PingRQ', $xml);
    }

    public function searchCruises()
    {
        $swota = new SimpleSwOTAService();

        // Search cruises
        $sailings = $swota->searchSailings('2024-06-01', '2024-08-31');

        return response()->json($sailings);
    }

    public function findCruise()
    {
        $swota = new SimpleSwOTAService();

        // 1. Search available sailings
        $sailings = $swota->searchSailings(
            now()->format('Y-m-d'),
            now()->addMonths(3)->format('Y-m-d')
        );

        // 2. Get categories for a specific voyage
        $categories = $swota->getCategories('VOYAGE123', 2);

        // 3. Get available cabins
        $cabins = $swota->getCabins('VOYAGE123', 'A', 2);

        return view('cruises', [
            'sailings'   => $sailings,
            'categories' => $categories,
            'cabins'     => $cabins,
        ]);
    }

}
