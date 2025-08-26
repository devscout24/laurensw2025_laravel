<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Extra;
use App\Models\Photo;
use App\Models\CabinTwo;
use App\Models\TripsTwo;
use App\Models\ItineraryTwo;
use Illuminate\Http\Request;
use App\Models\DestinationTwo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TripsTwoController extends Controller
{
    /**
     *  trips lists
     */
    public function index()
    {
        $data = TripsTwo::with([
            'cabinsTwos',
            'extras',
            'destinationsTwos',
            'photos',
            'itinerariesTwos',
        ])->paginate(10);
        return view('backend.layout.tazim.trips-two.index', compact('data'));
    }

    /**
     * Import trips from API
     */

    public function importTrips()
    {
        try {
            $response = Http::get("https://oceanwide-expeditions.com/trip-feed/agents?currency=USD");

            if ($response->failed()) {
                Log::error('API request failed');
                return response()->json(['error' => 'API request failed'], 500);
            }

            $data = $response->json();

            if (!isset($data['trips'])) {
                Log::error('Invalid API response structure');
                return response()->json(['error' => 'Invalid API response structure'], 500);
            }

            foreach ($data['trips'] as $trip) {
                // Main trip insert/update
                $tripModel = TripsTwo::updateOrCreate(
                    ['external_id' => $trip['id']],
                    [
                        'region' => $trip['region'] ?? null,
                        'url' => $trip['url'] ?? null,
                        'code' => $trip['code'] ?? null,
                        'combination' => $trip['combination'] ?? false,
                        'only_in_combination' => $trip['only_in_combination'] ?? false,
                        'translated' => $trip['translated'] ?? false,
                        'departure_date' => $trip['departure_date'] ?? null,
                        'return_date' => $trip['return_date'] ?? null,
                        'name' => $trip['name'] ?? null,
                        'summary' => $trip['summary'] ?? null,
                        'embark' => $trip['embark'] ?? null,
                        'disembark' => $trip['disembark'] ?? null,
                        'dr_usp' => $trip['dr_usp'] ?? null,
                        'trip_included' => $trip['trip_included'] ?? null,
                        'trip_excluded' => $trip['trip_excluded'] ?? null,
                        'days' => $trip['days'] ?? null,
                        'nights' => $trip['nights'] ?? null,
                        'ship_id' => $trip['ship_id'] ?? null,
                        'ship_name' => $trip['ship'] ?? null,
                        'map' => $trip['map'] ?? null,
                    ]
                );

                if (!$tripModel) {
                    Log::warning("Trip ID {$trip['id']} not inserted/updated.");
                }

                // Cabins
                if (isset($trip['cabins'])) {
                    foreach ($trip['cabins'] as $cabin) {
                        $cabinModel = CabinTwo::updateOrCreate(
                            ['trips_two_id' => $tripModel->id, 'cabin_id' => $cabin['cabin_id']],
                            [
                                'title' => $cabin['title'] ?? null,
                                'price' => $cabin['price'] ?? null,
                                'old_price' => $cabin['old_price'] ?? null,
                                'discount' => $cabin['discount'] ?? null,
                                'cab_units' => $cabin['cab_units'] ?? 0,
                                'ber_units' => $cabin['ber_units'] ?? 0,
                                'male_units' => $cabin['male_units'] ?? 0,
                                'female_units' => $cabin['female_units'] ?? 0,
                            ]
                        );
                        if (!$cabinModel) {
                            Log::warning("Cabin ID {$cabin['cabin_id']} for Trip ID {$trip['id']} not inserted/updated.");
                        }
                    }
                } else {
                    Log::info("No cabins found for Trip ID {$trip['id']}");
                }

                // Extras
                if (isset($trip['extras'])) {
                    foreach ($trip['extras'] as $extra) {
                        $extraModel = Extra::updateOrCreate(
                            ['trips_two_id' => $tripModel->id, 'name' => $extra['name']],
                            ['availability' => $extra['availability'] ?? null, 'price' => $extra['price'] ?? null]
                        );
                        if (!$extraModel) {
                            Log::warning("Extra {$extra['name']} for Trip ID {$trip['id']} not inserted/updated.");
                        }
                    }
                } else {
                    Log::info("No extras found for Trip ID {$trip['id']}");
                }

                // Destinations
                if (isset($trip['destinations'])) {
                    foreach ($trip['destinations'] as $dest) {
                        $destModel = DestinationTwo::updateOrCreate(
                            ['trips_two_id' => $tripModel->id, 'name' => $dest]
                        );
                        if (!$destModel) {
                            Log::warning("Destination {$dest} for Trip ID {$trip['id']} not inserted/updated.");
                        }
                    }
                } else {
                    Log::info("No destinations found for Trip ID {$trip['id']}");
                }

                // Photos
                if (isset($trip['photos'])) {
                    foreach ($trip['photos'] as $photo) {
                        $photoModel = Photo::updateOrCreate(
                            ['trips_two_id' => $tripModel->id, 'url' => $photo]
                        );
                        if (!$photoModel) {
                            Log::warning("Photo {$photo} for Trip ID {$trip['id']} not inserted/updated.");
                        }
                    }
                } else {
                    Log::info("No photos found for Trip ID {$trip['id']}");
                }

                // Itineraries
                if (isset($trip['itineraries'])) {
                    foreach ($trip['itineraries'] as $itinerary) {
                        $itineraryModel = ItineraryTwo::updateOrCreate(
                            ['trips_two_id' => $tripModel->id, 'day' => $itinerary['day']],
                            [
                                'title' => $itinerary['title'] ?? null,
                                'summary' => $itinerary['summary'] ?? null,
                                'port' => $itinerary['port'] ?? null,
                                'location' => $itinerary['location'] ?? null,
                            ]
                        );
                        if (!$itineraryModel) {
                            Log::warning("Itinerary day {$itinerary['day']} for Trip ID {$trip['id']} not inserted/updated.");
                        }
                    }
                } else {
                    Log::info("No itineraries found for Trip ID {$trip['id']}");
                }
            }

            Log::info("Trips import Completed successfully !!");
            return redirect()->back()->with('success', 'Trips imported successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error importing trips: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        /* $trip = TripsTwo::find($id);
        return view('trips.two.show', compact('trip')); */
    }
}
