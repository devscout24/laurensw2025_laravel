<?php
namespace App\Http\Controllers;

use App\Models\CabinTwo;
use App\Models\DestinationTwo;
use App\Models\Extra;
use App\Models\ItineraryTwo;
use App\Models\Photo;
use App\Models\TripsTwo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

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

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = TripsTwo::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('departure_date', function ($row) {
                    return $row->departure_date ? Carbon::parse($row->departure_date)->format('d F Y') : 'N/A';
                })
                ->addColumn('return_date', function ($row) {
                    return $row->return_date ? Carbon::parse($row->return_date)->format('d F Y') : 'N/A';
                })
                ->addColumn('region', function ($row) {
                    return $row->region ? $row->region : 'N/A';
                })
                ->addColumn('code', function ($row) {
                    return $row->code ? $row->code : 'N/A';
                })
                ->addColumn('combination', function ($row) {
                    return $row->combination ? $row->combination : 'N/A';
                })
                ->addColumn('only_in_combination', function ($row) {
                    return $row->only_in_combination ? $row->only_in_combination : 'N/A';
                })
                ->addColumn('name', function ($row) {
                    return $row->name ? Str::words(strip_tags($row->name), 8, '...') : 'N/A';
                })
                ->addColumn('embark', function ($row) {
                    return $row->embark ? $row->embark : 'N/A';
                })
                ->addColumn('disembark', function ($row) {
                    return $row->disembark ? $row->disembark : 'N/A';
                })
                ->addColumn('days', function ($row) {
                    return $row->days ? $row->days : 'N/A';
                })
                ->addColumn('nights', function ($row) {
                    return $row->nights ? $row->nights : 'N/A';
                })
                ->addColumn('ship_name', function ($row) {
                    return $row->ship_name ? $row->ship_name : 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a class="btn btn-sm btn-primary" href="' . route('trips.two.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['departure_date', 'return_date', 'action'])
                ->make(true);
        }

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

            if (! isset($data['trips'])) {
                Log::error('Invalid API response structure');
                return response()->json(['error' => 'Invalid API response structure'], 500);
            }

            foreach ($data['trips'] as $trip) {
                // Main trip insert/update
                $tripModel = TripsTwo::updateOrCreate(
                    ['external_id' => $trip['id']],
                    [
                        'region'              => $trip['region'] ?? null,
                        'url'                 => $trip['url'] ?? null,
                        'code'                => $trip['code'] ?? null,
                        'combination'         => $trip['combination'] ?? false,
                        'only_in_combination' => $trip['only_in_combination'] ?? false,
                        'translated'          => $trip['translated'] ?? false,
                        'departure_date'      => $trip['departure_date'] ?? null,
                        'return_date'         => $trip['return_date'] ?? null,
                        'name'                => $trip['name'] ?? null,
                        'summary'             => $trip['summary'] ?? null,
                        'embark'              => $trip['embark'] ?? null,
                        'disembark'           => $trip['disembark'] ?? null,
                        'dr_usp'              => $trip['dr_usp'] ?? null,
                        'trip_included'       => $trip['trip_included'] ?? null,
                        'trip_excluded'       => $trip['trip_excluded'] ?? null,
                        'days'                => $trip['days'] ?? null,
                        'nights'              => $trip['nights'] ?? null,
                        'ship_id'             => $trip['ship_id'] ?? null,
                        'ship_name'           => $trip['ship'] ?? null,
                        'map'                 => $trip['map'] ?? null,
                    ]
                );

                if (! $tripModel) {
                    Log::warning("Trip ID {$trip['id']} not inserted/updated.");
                }

                // Cabins
                if (isset($trip['cabins'])) {
                    foreach ($trip['cabins'] as $cabin) {
                        $cabinModel = CabinTwo::updateOrCreate(
                            ['trips_two_id' => $tripModel->id, 'cabin_id' => $cabin['cabin_id']],
                            [
                                'title'        => $cabin['title'] ?? null,
                                'price'        => $cabin['price'] ?? null,
                                'old_price'    => $cabin['old_price'] ?? null,
                                'discount'     => $cabin['discount'] ?? null,
                                'cab_units'    => $cabin['cab_units'] ?? 0,
                                'ber_units'    => $cabin['ber_units'] ?? 0,
                                'male_units'   => $cabin['male_units'] ?? 0,
                                'female_units' => $cabin['female_units'] ?? 0,
                            ]
                        );
                        if (! $cabinModel) {
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
                        if (! $extraModel) {
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
                        if (! $destModel) {
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
                        if (! $photoModel) {
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
                                'title'    => $itinerary['title'] ?? null,
                                'summary'  => $itinerary['summary'] ?? null,
                                'port'     => $itinerary['port'] ?? null,
                                'location' => $itinerary['location'] ?? null,
                            ]
                        );
                        if (! $itineraryModel) {
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
        // Load trip with all relations
        $trip = TripsTwo::with([
            'cabinsTwos',
            'extras',
            'destinationsTwos',
            'photos',
            'itinerariesTwos',
        ])->findOrFail($id);

        return view('backend.layout.tazim.trips-two.show', compact('trip'));
    }
}
