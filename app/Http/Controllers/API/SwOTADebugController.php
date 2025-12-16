<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\apiresponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SwOTADebugController extends Controller
{
    use apiresponse;

    /**
     * Step 1: Test Auth0 token generation
     */
    public function testAuth()
    {
        $clientId     = '5000634';
        $clientSecret = '3yLSJdzHfbUo7jt_6y90uRuBoN-0awLimx17ur8xsTZZcdPTtgSVIv6LRZl-6lRz';
        $environment  = 'development';

        // Clear any cached token
        Cache::forget('swota_token');

        $tokenUrl = $environment === 'production'
            ? 'https://partner-travelhx.eu.auth0.com/oauth/token'
            : 'https://travelhx-backend-stage.eu.auth0.com/oauth/token';

        $audience = $environment === 'production'
            ? 'https://partner.travelhx.com/api'
            : 'https://partner.dev.travelhx.dev/api';

        try {
            $response = Http::timeout(30)->post($tokenUrl, [
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'audience'      => $audience,
                'grant_type'    => 'client_credentials',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success'       => true,
                    'message'       => '✅ Auth0 token obtained successfully!',
                    'token_url'     => $tokenUrl,
                    'audience'      => $audience,
                    'token'         => substr($data['access_token'], 0, 50) . '...',
                    'expires_in'    => $data['expires_in'] ?? null,
                    'full_response' => $data,
                ]);
            }

            return response()->json([
                'success'   => false,
                'message'   => '❌ Auth0 authentication failed',
                'token_url' => $tokenUrl,
                'audience'  => $audience,
                'status'    => $response->status(),
                'error'     => $response->json(),
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Exception occurred',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Step 2: Test API ping with token
     */
    public function testPing()
    {
        $clientId     = 'aEHuEecIOk39LGDsy0NPRgLwZgKzNPfu';
        $clientSecret = '3yLSJdzHfbUo7jt_6y90uRuBoN-0awLimx17ur8xsTZZcdPTtgSVIv6LRZl-6lRz';
        $agencyId     = '5000634';
        $environment  = 'development';

        try {
            // Step 1: Get token
            $tokenUrl = 'https://travelhx-backend-stage.eu.auth0.com/oauth/token';
            $audience = 'https://partner.dev.travelhx.dev/api';

            $authResponse = Http::timeout(30)->post($tokenUrl, [
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'audience'      => $audience,
                'grant_type'    => 'client_credentials',
            ]);

            if (! $authResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'step'    => 'authentication',
                    'message' => '❌ Failed to get token',
                    'error'   => $authResponse->json(),
                ], $authResponse->status());
            }

            $token = $authResponse->json()['access_token'];

            // Step 2: Make ping request
            $apiUrl    = 'https://bookings-dev.sw.travelhx.com/ota/rest';
            $timestamp = now()->format('Y-m-d\TH:i:s\Z');

            $xml = <<<XML
            <?xml version="1.0"?>
            <OTA_PingRQ xmlns="http://www.opentravel.org/OTA/2003/05" Version="1.0" TimeStamp="{$timestamp}">
                <EchoData>Test connection</EchoData>
            </OTA_PingRQ>
            XML;

            $apiResponse = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/xml',
            ])->send('POST', $apiUrl . '/OTA_PingRQ', [
                'body' => $xml,
            ]);

            if ($apiResponse->successful()) {
                return response()->json([
                    'success'  => true,
                    'message'  => '✅ Ping successful!',
                    'status'   => $apiResponse->status(),
                    'response' => $apiResponse->body(),
                ]);
            }

            return response()->json([
                'success'     => false,
                'step'        => 'api_request',
                'message'     => '❌ API request failed',
                'status'      => $apiResponse->status(),
                'request_url' => $apiUrl . '/OTA_PingRQ',
                'response'    => $apiResponse->body(),
            ], $apiResponse->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Exception occurred',
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], 500);
        }
    }

    /**
     * Step 3: Test with POS element
     */
    public function testWithPOS()
    {
        $clientId     = 'aEHuEecIOk39LGDsy0NPRgLwZgKzNPfu';
        $clientSecret = '3yLSJdzHfbUo7jt_6y90uRuBoN-0awLimx17ur8xsTZZcdPTtgSVIv6LRZl-6lRz';
        $agencyId     = '5000634';
        $companyName  = 'Polar_Travel';

        try {
            // Get token
            $authResponse = Http::timeout(30)->post('https://travelhx-backend-stage.eu.auth0.com/oauth/token', [
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'audience'      => 'https://partner.dev.travelhx.dev/api',
                'grant_type'    => 'client_credentials',
            ]);

            if (! $authResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'error'   => 'Auth failed',
                    'details' => $authResponse->json(),
                ]);
            }

            $token     = $authResponse->json()['access_token'];
            $timestamp = now()->format('Y-m-d\TH:i:s\Z');

            // Test sailing search with POS
            $xml = <<<XML
            <?xml version="1.0"?>
            <OTA_CruiseSailAvailRQ xmlns="http://www.opentravel.org/OTA/2003/05" Version="1.0" TimeStamp="{$timestamp}">
                <POS>
                    <Source>
                        <RequestorID ID="{$agencyId}" Type="5" ID_Context="SEAWARE"/>
                        <BookingChannel Type="1">
                            <CompanyName>{$companyName}</CompanyName>
                        </BookingChannel>
                    </Source>
                </POS>
                <SailingDateRange>
                    <StartDateWindow EarliestDate="2025-06-01"/>
                    <EndDateWindow LatestDate="2025-08-31"/>
                </SailingDateRange>
            </OTA_CruiseSailAvailRQ>
            XML;

            $apiResponse = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/xml',
            ])->send('POST', 'https://bookings-dev.sw.travelhx.com/ota/rest/OTA_CruiseSailAvailRQ', [
                'body' => $xml,
            ]);

            return response()->json([
                'success'     => $apiResponse->successful(),
                'status'      => $apiResponse->status(),
                'message'     => $apiResponse->successful() ? '✅ Request successful!' : '❌ Request failed',
                'response'    => $apiResponse->body(),
                'request_xml' => $xml,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear cached token
     */
    public function clearCache()
    {
        Cache::forget('swota_token');

        return response()->json([
            'success' => true,
            'message' => '✅ Cache cleared! Try your request again.',
        ]);
    }
}
