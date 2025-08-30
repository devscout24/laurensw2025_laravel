<?php

namespace App\Jobs;

use App\Models\Trip;
use App\Models\Ship;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportChunkJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    public $timeout = 600; // 10 min
    public $tries = 5;

    protected $trips;

    /**
     * Create a new job instance.
     */
    public function __construct(array $trips)
    {
        $this->trips = $trips;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->trips as $tripData) {
            try {
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
            } catch (\Throwable $e) {
                Log::error("ImportChunkJob failed: " . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
    }
}
