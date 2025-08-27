<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cruise;
use App\Models\Ship;
use App\Models\Trip;
use App\Traits\apiresponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class TourListsDetailsController extends Controller
{
    use apiresponse;

    /**
     * Show all trips In Admin Dashboard
     */
    public function index()
    {
        $data = Trip::with([
            'ship',
            'cabins',
            'itineraries',
            'destinations',
            'locations',
            'countrries',
            'gallery',
        ])->paginate(10);
        return view('backend.layout.tazim.trips.index', compact('data'));
    }

    public function getDataList(Request $request)
    {
        if ($request->ajax()) {
            $data = Trip::with(['ship', 'destinations', 'cabins', 'gallery'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name ?? 'N/A';
                })
                ->addColumn('ship_name', function ($row) {
                    return $row->ship->name ?? 'N/A';
                })
                ->addColumn('destinations', function ($row) {
                    if ($row->destinations->count()) {
                        return $row->destinations->pluck('name')->implode(', ');
                    }
                    return 'N/A';
                })
                ->addColumn('cabins_count', function ($row) {
                    return $row->cabins ? $row->cabins->count() : 0;
                })
                ->addColumn('gallery_count', function ($row) {
                    return $row->gallery ? $row->gallery->count() : 0;
                })
                ->addColumn('action', function ($row) {
                    return '
                    <a class="btn btn-sm btn-primary" href="' . route('trips.show', $row->id) . '">
                        <i class="fa-solid fa-eye"></i>
                    </a>';
                })
                ->setRowAttr([
                    'data-id' => function ($row) {
                        return $row->id;
                    },
                ])
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show all trips details In Admin Dashboard
     */
    public function show($id)
    {
        $data = Trip::with([
            'ship.specs',
            'ship.gallery',
            'cabins',
            'cabins.prices',
            'itineraries',
            'destinations',
            'locations',
            'countrries',
            'gallery',
        ])->findOrFail($id);
        return view('backend.layout.tazim.trips.show', compact('data'));
    }

    /**
     * Retrieve data from API
     */

    public function getApiOne(Request $request)
    {
        // Validation for query params
        $validated = $request->validate([
            'page'     => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
        ]);

        $page    = $validated['page'] ?? 1;
        $perPage = $validated['per_page'] ?? 10;

        // API URL (no pagination, it returns all data)
        $url = "https://api.heritage-expeditions.com/v1/trips";

        // API call
        $response = Http::withHeaders([
            'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
            'Accept'        => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            // Convert all data into collection
            $data = collect($response->json());

            // Laravel internal pagination
            $paginated = new LengthAwarePaginator(
                $data->forPage($page, $perPage), // slice only needed items
                $data->count(),                  // total items
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return response()->json($paginated, 200);
        }

        return response()->json([
            'error'   => 'Failed to fetch data',
            'status'  => $response->status(),
            'message' => $response->body(),
        ], $response->status());
    }

    /**
     * Import Trips from API and store in database
     */
    public function importTrips(Request $request)
    {
        set_time_limit(600); //Maximum execution time of 60 seconds exceeded problem solved
        $url = "https://api.heritage-expeditions.com/v1/trips";
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
                'Accept'        => 'application/json',
            ])->get($url);

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

            $responseMessage = 'Trips imported successfully!';
            return redirect()->back()->with('success', 'Trips imported successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error importing trips: ' . $e->getMessage());
        }
    }

    /**
     * Get all Trips In API with filters
     */
    public function getTrips(Request $request)
    {
        try {
            $query = Trip::with([
                'ship.specs',
                'ship.gallery',
                'cabins',
                'cabins.prices',
                'itineraries',
                'destinations',
                'locations',
                'countrries',
                'gallery',
            ]);

            // Filter by destination
            if ($request->has('destinations')) {
                $destination = $request->input('destinations');
                $query->whereHas('destinations', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            // Filter by duration
            if ($request->has('duration')) {
                $query->where('duration', $request->duration);
            }

            // Filter by departure_date and return_date
            if ($request->has('departure_date')) {
                $query->whereDate('departure_date', '>=', $request->departure_date);
            }

            // Filter by ship name
            if ($request->has('ship')) {
                $query->whereHas('ship', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->ship . '%');
                });
            }

            // Paginate with filters
            $perPage = $request->input('per_page', 10);
            $trips   = $query->paginate($perPage);
            $trips->appends($request->all());

            // If no result is found
            if ($trips->isEmpty()) {
                return $this->success(
                    ['trips' => []],
                    'No trips found for the given filters.',
                    200
                );
            }

            return $this->success(
                ['trips' => $trips],
                'Trips retrieved successfully!',
                200
            );
        } catch (\Exception $e) {
            return $this->error(
                'Failed to retrieve trips.',
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Get Trips details In API
     */
    public function getTripsDetails($id)
    {
        try {
            $trip = Trip::with([
                'ship.specs',
                'ship.gallery',
                'cabins',
                'cabins.prices',
                'itineraries',
                'destinations',
                'locations',
                'countrries',
                'gallery',
            ])->findOrFail($id);

            return $this->success(
                ['trip' => $trip],
                'Trip Details retrieved successfully!',
                200
            );
        } catch (\Exception $e) {
            return $this->error(
                'Failed to retrieve trip.',
                $e->getMessage()
            );
        }
    }

    /**
     * Import Cruises from API and store in database
     */

    public function importCruise()
    {
        set_time_limit(600); //Maximum execution time of 60 seconds exceeded problem solved
        try {
            $url      = "https://poseidonexpeditions.com/feed/";
            $response = Http::get($url);

            if (! $response->ok()) {
                throw new \Exception("API request failed: " . $response->status());
            }

            $xml  = simplexml_load_string($response->body(), "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_decode(json_encode($xml), true);

            if (! isset($json['Cruise']) || empty($json['Cruise'])) {
                throw new \Exception("No Cruise data found in API response");
            }

            foreach ($json['Cruise'] as $trip) {
                try {
                    if (! isset($trip['ID'])) {
                        throw new \Exception("No ID field found");
                    }

                    $cruise = Cruise::updateOrCreate(
                        ['external_id' => $trip['ID']],
                        [
                            'name'           => $trip['Name'] ?? null,
                            'length'         => $trip['Length'] ?? null,
                            'ship_name'      => $trip['ShipName'] ?? null,
                            'destination'    => $trip['Destination'] ?? null,
                            'embarcation'    => $trip['Embarcation'] ?? null,
                            'disembarkation' => $trip['Disembarkation'] ?? null,
                            'start_date'     => isset($trip['StartDate'])
                            ? Carbon::createFromFormat('d-m-Y', $trip['StartDate'])->format('Y-m-d')
                            : null,
                            'end_date'       => isset($trip['EndDate'])
                            ? Carbon::createFromFormat('d-m-Y', $trip['EndDate'])->format('Y-m-d')
                            : null,
                            'url'            => $trip['Url'] ?? null,
                            'map_route'      => $trip['MapRoute'] ?? null,
                            // 'prices'         => json_encode($trip['Prices'])
                        ]
                    );

                    // Save Days
                    if (isset($trip['Days']['Day']) && is_array($trip['Days']['Day'])) {
                        foreach ($trip['Days']['Day'] as $day) {
                            $dayModel = $cruise->days()->updateOrCreate([
                                'title' => $day['Title'] ?? null,
                                'text'  => $day['Text'] ?? null,
                            ]);

                            if (isset($day['Images']['Image'])) {
                                $images = is_array($day['Images']['Image'])
                                ? $day['Images']['Image']
                                : [$day['Images']['Image']];
                                foreach ($images as $img) {
                                    $dayModel->images()->updateOrCreate(['image_url' => $img]);
                                }
                            }
                        }
                    }

                    // Save Highlights
                    if (isset($trip['Highlights']['Highlight'])) {
                        $highlights = is_array($trip['Highlights']['Highlight'])
                        ? $trip['Highlights']['Highlight']
                        : [$trip['Highlights']['Highlight']];
                        foreach ($highlights as $highlight) {
                            $cruise->highlights()->updateOrCreate([
                                'text' => $highlight ?? null,
                            ]);
                        }
                    }

                    // Save Notes
                    if (isset($trip['Notes']['Note'])) {
                        $notes = is_array($trip['Notes']['Note'])
                        ? $trip['Notes']['Note']
                        : [$trip['Notes']['Note']];

                        foreach ($notes as $note) {
                            $noteType    = $note['@attributes']['type'] ?? null;
                            $noteContent = $note['content'] ?? $note ?? null;

                            $cruise->notes()->create([
                                'type'    => $noteType,
                                'content' => is_array($noteContent) ? $noteContent : ['text' => $noteContent],
                            ]);
                        }
                    }

                    // Save Offers
                    if (isset($trip['Offers']['Offer'])) {
                        $offers = is_array($trip['Offers']['Offer'])
                        ? $trip['Offers']['Offer']
                        : [$trip['Offers']['Offer']];
                        foreach ($offers as $offer) {
                            $cruise->offers()->updateOrCreate([
                                'description' => $offer['Description'] ?? null,
                            ]);
                        }
                    }

                    // Save Cabins (Prices)
                    if (isset($trip['Prices']['Cabin'])) {
                        $cabins = is_array($trip['Prices']['Cabin'])
                        ? $trip['Prices']['Cabin']
                        : [$trip['Prices']['Cabin']];
                        foreach ($cabins as $cabin) {
                            $cruise->cabins()->updateOrCreate(
                                ['name' => $cabin['Name'] ?? null],
                                [
                                    'price'               => $cabin['Price'] ?? null,
                                    'price_with_discount' => $cabin['PriceWithDiscount'] ?? null,
                                ]
                            );
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Cruise import failed: " . $e->getMessage(), ['trip' => $trip]);
                }
            }

            return redirect()->back()->with('success', 'Cruises imported successfully!');
        } catch (\Exception $e) {
            Log::error("Cruise import main error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Get Cruise Lists In Admin Dashboard
     */
    public function cruiseLists()
    {
        return view('backend.layout.tazim.cruise.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Cruise::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('trip_dates', function ($row) {
                    $start = Carbon::parse($row->start_date)->format('d/m/Y');
                    $end   = Carbon::parse($row->end_date)->format('d/m/Y');
                    return $start . ' to ' . $end;
                })
                ->addColumn('name', function ($row) {
                    return $row->name ? $row->name : 'N/A';
                })
                ->addColumn('ship_name', function ($row) {
                    return $row->ship_name ? $row->ship_name : 'N/A';
                })
                ->addColumn('destination', function ($row) {
                    return $row->destination ? $row->destination : 'N/A';
                })
                ->addColumn('embarcation', function ($row) {
                    return $row->embarcation ? $row->embarcation : 'N/A';
                })
                ->addColumn('disembarkation', function ($row) {
                    return $row->disembarkation ? $row->disembarkation : 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a class="btn btn-sm btn-primary" href="' . route('cruise.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    /**
     * Show Cruise Details In Admin Dashboard
     */
    public function showDetails($id)
    {
        $data = Cruise::with([
            'days.images',
            'cabins',
            'highlights',
            'notes',
            'offers',

        ])->findOrFail($id);
        return view('backend.layout.tazim.cruise.show', compact('data'));
    }

    /**
     * Get Cruise Lists in API
     */
    public function getCruiseLists()
    {
        try {
            $data = Cruise::with([
                'days.images',
                'cabins',
                'highlights',
                'notes',
                'offers',
            ])->paginate(10);

            return $this->success($data, 'Cruises retrieved successfully', 200);
        } catch (\Exception $e) {
            Log::error("Cruise API error: " . $e->getMessage());
            return $this->error(null, 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get Cruise Details in API
     */
    public function getCruiseDetails($id)
    {
        try {
            $cruise = Cruise::with([
                'days.images',
                'cabins',
                'highlights',
                'notes',
                'offers',
            ])->find($id);

            if (! $cruise) {
                return $this->success($cruise, 'Cruise not found', 200);
            }

            return $this->success($cruise, 'Cruise details retrieved successfully');
        } catch (\Exception $e) {
            return $this->error(null, 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * New proxy route
     */
    /* public function imageProxy(Request $request)
    {
        set_time_limit(0);
        $url = $request->query('url');

        if (!$url) {
            abort(404);
        }

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                abort(404);
            }

            return response($response->body(), 200)
                ->header('Content-Type', $response->header('Content-Type'));
        } catch (\Exception $e) {
            abort(404);
        }
    } */
}
