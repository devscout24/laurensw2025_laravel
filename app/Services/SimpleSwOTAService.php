<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * SIMPLE SwOTA API Service
 * Just add your credentials and start using!
 */
class SimpleSwOTAService
{
                                                  // ⚠️ ADD YOUR CREDENTIALS HERE (or in .env)
    private $agencyId     = 'YOUR_AGENCY_ID';     // Get from SwOTA team
    private $companyName  = 'YOUR_COMPANY_NAME';  // Your company name
    private $clientId     = 'YOUR_CLIENT_ID';     // Get from SwOTA team
    private $clientSecret = 'YOUR_CLIENT_SECRET'; // Get from SwOTA team
    private $environment  = 'development';        // development, staging, or production

    private $accessToken = null;

    public function __construct()
    {
        // Load from .env if available
        if (env('SWOTA_AGENCY_ID')) {
            $this->agencyId     = env('SWOTA_AGENCY_ID');
            $this->companyName  = env('SWOTA_COMPANY_NAME');
            $this->clientId     = env('SWOTA_AUTH0_CLIENT_ID');
            $this->clientSecret = env('SWOTA_AUTH0_CLIENT_SECRET');
            $this->environment  = env('SWOTA_ENVIRONMENT', 'development');
        }
    }

    /**
     * Get API base URL
     */
    private function getApiUrl()
    {
        $urls = [
            'development' => 'https://bookings-dev.sw.travelhx.com/ota/rest',
            'staging'     => 'https://bookings-stage.sw.travelhx.com/ota/rest',
            'production'  => 'https://bookings.sw.travelhx.com/ota/rest',
        ];
        return $urls[$this->environment];
    }

    /**
     * Get Auth0 token URL
     */
    private function getTokenUrl()
    {
        return $this->environment === 'production'
            ? 'https://partner-travelhx.eu.auth0.com/oauth/token'
            : 'https://travelhx-backend-stage.eu.auth0.com/oauth/token';
    }

    /**
     * Get Auth0 audience
     */
    private function getAudience()
    {
        return $this->environment === 'production'
            ? 'https://partner.travelhx.com/api'
            : 'https://partner.dev.travelhx.dev/api';
    }

    /**
     * Get access token (with caching)
     */
    private function getToken()
    {
        // Check cache first
        $token = Cache::get('swota_token');
        if ($token) {
            return $token;
        }

        // Get new token
        $response = Http::timeout(30)->post($this->getTokenUrl(), [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'audience'      => $this->getAudience(),
            'grant_type'    => 'client_credentials',
        ]);

        if ($response->successful()) {
            $data  = $response->json();
            $token = $data['access_token'];

            // Cache for 23 hours
            Cache::put('swota_token', $token, now()->addHours(23));

            Log::info('SwOTA Token obtained successfully');

            return $token;
        }

        Log::error('SwOTA Auth failed', [
            'status'   => $response->status(),
            'body'     => $response->body(),
            'url'      => $this->getTokenUrl(),
            'audience' => $this->getAudience(),
        ]);

        throw new \Exception('Authentication failed: ' . $response->body());
    }

    /**
     * Make API request
     */
    private function request($endpoint, $xmlBody)
    {
        $token = $this->getToken();

        Log::info('SwOTA Request', [
            'endpoint'  => $endpoint,
            'url'       => $this->getApiUrl() . '/' . $endpoint,
            'has_token' => ! empty($token),
        ]);

        $response = Http::timeout(30)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/xml',
        ])->send('POST', $this->getApiUrl() . '/' . $endpoint, [
            'body' => $xmlBody,
        ]);

        Log::info('SwOTA Response', [
            'status' => $response->status(),
            'body'   => substr($response->body(), 0, 500),
        ]);

        if ($response->successful()) {
            // Convert XML to array
            $xml = simplexml_load_string($response->body());
            return json_decode(json_encode($xml), true);
        }

        // If token expired, clear cache and retry once
        if ($response->status() === 401) {
            Log::warning('Token expired, retrying...');
            Cache::forget('swota_token');
            $this->accessToken = null;

            // Retry once
            return $this->request($endpoint, $xmlBody);
        }

        throw new \Exception('API Error: ' . $response->body());
    }

    /**
     * Build POS section for XML
     */
    private function buildPOS()
    {
        return "<POS><Source><RequestorID ID=\"{$this->agencyId}\" Type=\"5\" ID_Context=\"SEAWARE\"/><BookingChannel Type=\"1\"><CompanyName>{$this->companyName}</CompanyName></BookingChannel></Source></POS>";
    }

    // ==================== PUBLIC METHODS ====================

    /**
     * 1. Test connection
     * Usage: $service->ping();
     */
    public function ping()
    {
        $timestamp = now()->format('Y-m-d\TH:i:s\Z');
        $xml       = <<<XML
        <?xml version="1.0"?>
        <OTA_PingRQ xmlns="http://www.opentravel.org/OTA/2003/05" Version="1.0" TimeStamp="{$timestamp}">
            <EchoData>Test connection</EchoData>
        </OTA_PingRQ>
        XML;

        return $this->request('OTA_PingRQ', $xml);
    }

    /**
     * 2. Search sailings
     * Usage: $service->searchSailings('2024-06-01', '2024-08-31');
     */
    public function searchSailings($startDate, $endDate)
    {
        $timestamp = now()->format('Y-m-d\TH:i:s\Z');
        $pos       = $this->buildPOS();

        $xml = <<<XML
        <!-- <?xml version="1.0"?> -->
        <OTA_CruiseSailAvailRQ xmlns="http://www.opentravel.org/OTA/2003/05" Version="1.0" TimeStamp="{$timestamp}">
            {$pos}
            <SailingDateRange>
                <StartDateWindow EarliestDate="{$startDate}"/>
                <EndDateWindow LatestDate="{$endDate}"/>
            </SailingDateRange>
        </OTA_CruiseSailAvailRQ>
        XML;

        return $this->request('OTA_CruiseSailAvailRQ', $xml);
    }

    /**
     * 3. Get categories for a voyage
     * Usage: $service->getCategories('VOYAGE123', 2);
     */
    public function getCategories($voyageId, $guestCount = 2)
    {
        $timestamp = now()->format('Y-m-d\TH:i:s\Z');
        $pos       = $this->buildPOS();
        $guests    = str_repeat('<Guest/>', $guestCount);

        $xml = <<<XML
        <?xml version="1.0"?>
        <OTA_CruiseCategoryAvailRQ xmlns="http://www.opentravel.org/OTA/2003/05" Version="1.0" TimeStamp="{$timestamp}">
            {$pos}
            {$guests}
            <GuestCounts>
                <GuestCount Code="10" Quantity="{$guestCount}"/>
            </GuestCounts>
            <SailingInfo>
                <SelectedSailing VoyageID="{$voyageId}">
                    <CruiseLine/>
                </SelectedSailing>
            </SailingInfo>
            <SelectedFare FareCode="BESTPRICE"/>
        </OTA_CruiseCategoryAvailRQ>
        XML;

        return $this->request('OTA_CruiseCategoryAvailRQ', $xml);
    }

    /**
     * 4. Get cabins for a category
     * Usage: $service->getCabins('VOYAGE123', 'A', 2);
     */
    public function getCabins($voyageId, $categoryCode, $guestCount = 2)
    {
        $timestamp = now()->format('Y-m-d\TH:i:s\Z');
        $pos       = $this->buildPOS();
        $guests    = str_repeat('<Guest/>', $guestCount);

        $xml = <<<XML
        <?xml version="1.0"?>
        <OTA_CruiseCabinAvailRQ xmlns="http://www.opentravel.org/OTA/2003/05" Version="1.0" TimeStamp="{$timestamp}">
            {$pos}
            {$guests}
            <GuestCounts>
                <GuestCount Code="10" Quantity="{$guestCount}"/>
            </GuestCounts>
            <SailingInfo>
                <SelectedSailing VoyageID="{$voyageId}">
                    <CruiseLine/>
                </SelectedSailing>
                <SelectedCategory PricedCategoryCode="{$categoryCode}"/>
            </SailingInfo>
        </OTA_CruiseCabinAvailRQ>
        XML;

        return $this->request('OTA_CruiseCabinAvailRQ', $xml);
    }

    /**
     * 5. Get booking details
     * Usage: $service->getBooking('12345');
     */
    public function getBooking($bookingId)
    {
        $timestamp = now()->format('Y-m-d\TH:i:s\Z');
        $pos       = $this->buildPOS();

        $xml = <<<XML
        <?xml version="1.0"?>
        <OTA_ReadRQ xmlns="http://www.opentravel.org/OTA/2003/05" Version="1.0" TimeStamp="{$timestamp}">
            {$pos}
            <UniqueID ID="{$bookingId}" Type="14" ID_Context="SEAWARE"/>
        </OTA_ReadRQ>
        XML;

        return $this->request('OTA_ReadRQ', $xml);
    }
}
