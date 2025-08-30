<?php
namespace App\Http\Controllers\API;

use Exception;
use Carbon\Carbon;
use App\Models\Ship;
use App\Models\Trip;
use App\Models\Cruise;
use App\Traits\apiresponse;
use App\Jobs\ImportTripsJob;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class TourListsDetailsController extends Controller
{
    use apiresponse;

    /**
     * Show all trips In Admin Dashboard
     */
    public function index()
    {
        // $data = Trip::with([
        //     'ship',
        //     'cabins',
        //     'itineraries',
        //     'destinations',
        //     'locations',
        //     'countrries',
        //     'gallery',
        // ])->paginate(10);
        return view('backend.layout.tazim.trips.index');
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
         ImportTripsJob::dispatch();

    return redirect()->back()->with('success', 'Trips import job dispatched! Data will be imported in background.');
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
            $perPage = $request->input('per_page', 9);
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
            ])->paginate(9);

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
