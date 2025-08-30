<?php

namespace App\Jobs;

use Exception;
use App\Models\Ship;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportTripsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 800;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $url = "https://api.heritage-expeditions.com/v1/trips/";
            Log::info("Trips import started...");

            $response = Http::withHeaders([
                'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
                'Accept'        => 'application/json',
            ])->timeout(120)->get($url);

            if (! $response->successful()) {
                throw new Exception('Failed to fetch data');
            }

            $trips = $response->json();

            foreach ($trips as $tripData) {
                // Insert Trip
                $trip = Trip::updateOrCreate(
                    ['trip_code' => $tripData['trip_code'] ?? uniqid('trip_')], // fallback if trip_code missing
                    [
                        'name'            => $tripData['name'] ?? null,
                        'subtitle'        => $tripData['subtitle'] ?? null,
                        'supplier'        => $tripData['supplier'] ?? null,
                        'highlights'      => $tripData['highlights'] ?? null,
                        'description'     => $tripData['description'] ?? null,
                        'departure_date'  => $tripData['departure_date'] ?? null,
                        'return_date'     => $tripData['return_date'] ?? null,
                        'availability'    => $tripData['availability'] ?? null,
                        'feature_image'   => $tripData['feature_image'] ?? null,
                        'starting_city'   => $tripData['starting_city'] ?? null,
                        'finishing_city'  => $tripData['finishing_city'] ?? null,
                        'starting_point'  => $tripData['starting_point'] ?? null,
                        'finishing_point' => $tripData['finishing_point'] ?? null,
                        'duration'        => $tripData['duration'] ?? null,
                        'includes'        => $tripData['includes'] ?? null,
                        'excludes'        => $tripData['excludes'] ?? null,
                    ]
                );

                // Insert Ship
                if (! empty($tripData['ship'])) {
                    $shipData = $tripData['ship'];

                    $ship = Ship::updateOrCreate(
                        ['trip_id' => $trip->id],
                        [
                            'name'               => $shipData['name'] ?? null,
                            'description'        => $shipData['description'] ?? null,
                            'feature_image'      => $shipData['feature_image'] ?? null,
                            'cabin_layout_image' => $shipData['cabin_layout_image'] ?? null,
                            'last_known_long'    => $shipData['last_known_location']['long'] ?? null,
                            'last_known_lat'     => $shipData['last_known_location']['lat'] ?? null,
                            'last_updated'       => $shipData['last_known_location']['last_updated'] ?? null,
                        ]
                    );

                    // Ship Specs
                    if (! empty($shipData['ship_specs'])) {
                        foreach ($shipData['ship_specs'] as $spec) {
                            $ship->specs()->updateOrCreate(
                                ['name' => $spec['name']],
                                ['value' => $spec['value']]
                            );
                        }
                    }

                    // Ship Gallery
                    if (! empty($shipData['gallery'])) {
                        foreach ($shipData['gallery'] as $image) {
                            $ship->gallery()->updateOrCreate(['image' => $image]);
                        }
                    }
                }

                // Cabins
                if (! empty($tripData['cabins'])) {
                    foreach ($tripData['cabins'] as $cabinData) {
                        $cabin = $trip->cabins()->updateOrCreate(
                            ['name' => $cabinData['name']],
                            [
                                'description'  => $cabinData['description'] ?? null,
                                'amount'       => $cabinData['price']['amount'] ?? null,
                                'currency'     => $cabinData['price']['currency'] ?? null,
                                'deck_level'   => $cabinData['deck_level'] ?? null,
                                'image'        => $cabinData['image'] ?? null,
                                'inclusions'   => $cabinData['inclusions'] ?? null,
                                'exclusions'   => $cabinData['exclusions'] ?? null,
                                'availability' => $cabinData['availability'] ?? null,
                            ]
                        );

                        // Cabin Prices
                        if (! empty($cabinData['prices'])) {
                            foreach ($cabinData['prices'] as $price) {
                                $cabin->prices()->updateOrCreate(
                                    ['amount' => $price['amount'], 'currency' => $price['currency']]
                                );
                            }
                        }
                    }
                }

                // Itinerary
                if (! empty($tripData['itinerary'])) {
                    foreach ($tripData['itinerary'] as $item) {
                        $trip->itineraries()->updateOrCreate(
                            ['day' => $item['day']],
                            [
                                'label' => $item['label'] ?? null,
                                'body'  => $item['body'] ?? null,
                            ]
                        );
                    }
                }

                //  Destinations
                if (! empty($tripData['destinations'])) {
                    foreach ($tripData['destinations'] as $destinationName) {
                        $trip->destinations()->updateOrCreate(
                            [
                                // condition part
                                'trip_id' => $trip->id, // bind with trip
                                'name'    => $destinationName,
                            ],
                            [
                                // update part
                                'name' => $destinationName,
                            ]
                        );
                    }
                }

                //  Locations
                if (! empty($tripData['locations'])) {
                    foreach ($tripData['locations'] as $location) {
                        $trip->locations()->updateOrCreate(['name' => $location]);
                    }
                }

                //  Countries
                if (! empty($tripData['countries'])) {
                    foreach ($tripData['countries'] as $country) {
                        $trip->countrries()->updateOrCreate(['name' => $country]);
                    }
                }

                //  Trip Gallery
                if (! empty($tripData['gallery'])) {
                    foreach ($tripData['gallery'] as $image) {
                        $trip->gallery()->updateOrCreate(['image' => $image]);
                    }
                }
            }
            Log::info("Trips import completed successfully!");
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error("Trips import failed: " . $e->getMessage());

            // Re-throw to mark the job as failed
            throw $e;
        }
    }
}
