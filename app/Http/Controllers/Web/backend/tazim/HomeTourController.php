<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HomeTour;
use App\Models\PopularNatureTour;
use App\Models\Ship;
use App\Models\Trip;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class HomeTourController extends Controller
{
    public function index()
    {
        $data = HomeTour::all();
        return view('backend.layout.tazim.homeTour.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = HomeTour::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return Str::words(strip_tags($row->title), 15, '...');
                })
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('homeTour.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <button type="button"  onclick="deleteData(\'' . route('homeTour.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })

                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['title', 'image', 'action'])
                ->make(true);
        }

    }

    public function create()
    {
        $natureData = PopularNatureTour::whereId(1)->first();
        return view('backend.layout.tazim.homeTour.create', compact('natureData'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header'       => 'required|max:100',
            'title'        => 'required|max:500',
            'image'        => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            'duration'     => 'required',
            'ship'         => 'required',
            'price'        => 'required|decimal:2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data = new HomeTour();
        $data->header   = $request->header;
        $data->title    = $request->title;
        $data->duration = $request->duration;
        $data->ship     = $request->ship;
        $data->price    = $request->price;

        if ($request->hasFile('image')) {
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/homeTour'), $filename);
            $data->image = 'backend/images/homeTour/' . $filename;
        }
        $data->save();
        return redirect()->route('homeTour.list')->with('success', 'Home Tour Created Successfully');
    }

    public function edit($id)
    {
        $data = HomeTour::findOrFail($id);
        return view('backend.layout.tazim.homeTour.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = HomeTour::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'header'       => 'required|max:100',
            'title'        => 'required|max:500',
            'image'        => 'file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            'duration'     => 'required',
            'ship'         => 'required',
            'price'        => 'required|decimal:2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data->header   = $request->header;
        $data->title    = $request->title;
        $data->duration = $request->duration;
        $data->ship     = $request->ship;
        $data->price    = $request->price;

        if ($request->hasFile('image')) {
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/homeTour'), $filename);
            $data->image = 'backend/images/homeTour/' . $filename;
        }
        $data->save();
        return redirect()->route('homeTour.list')->with('success', 'Home Tour Updated Successfully');
    }

    public function delete($id)
    {
        $data = HomeTour::findOrFail($id);
        if (! empty($data->image) && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('homeTour.list')->with('success', 'Home Tour Deleted Successfully');
    }

    public function importTrips(Request $request)
    {
        $url = "https://api.heritage-expeditions.com/v1/trips";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
                'Accept' => 'application/json',
            ])->get($url);

            if (!$response->successful()) {
                throw new Exception('Failed to fetch data');
            }

            $trips = $response->json();

            foreach ($trips as $tripData) {
                // Insert Trip
                $trip = Trip::updateOrCreate(
                    ['trip_code' => $tripData['trip_code'] ?? uniqid('trip_')], // fallback if trip_code missing
                    [
                        'name' => $tripData['name'] ?? null,
                        'subtitle' => $tripData['subtitle'] ?? null,
                        'supplier' => $tripData['supplier'] ?? null,
                        'highlights' => $tripData['highlights'] ?? null,
                        'description' => $tripData['description'] ?? null,
                        'departure_date' => $tripData['departure_date'] ?? null,
                        'return_date' => $tripData['return_date'] ?? null,
                        'availability' => $tripData['availability'] ?? null,
                        'feature_image' => $tripData['feature_image'] ?? null,
                        'starting_city' => $tripData['starting_city'] ?? null,
                        'finishing_city' => $tripData['finishing_city'] ?? null,
                        'starting_point' => $tripData['starting_point'] ?? null,
                        'finishing_point' => $tripData['finishing_point'] ?? null,
                        'duration' => $tripData['duration'] ?? null,
                        'includes' => $tripData['includes'] ?? null,
                        'excludes' => $tripData['excludes'] ?? null,
                    ]
                );

                // Insert Ship
                if (!empty($tripData['ship'])) {
                    $shipData = $tripData['ship'];

                    $ship = Ship::updateOrCreate(
                        ['trip_id' => $trip->id],
                        [
                            'name' => $shipData['name'] ?? null,
                            'description' => $shipData['description'] ?? null,
                            'feature_image' => $shipData['feature_image'] ?? null,
                            'cabin_layout_image' => $shipData['cabin_layout_image'] ?? null,
                            'last_known_long' => $shipData['last_known_location']['long'] ?? null,
                            'last_known_lat' => $shipData['last_known_location']['lat'] ?? null,
                            'last_updated' => $shipData['last_known_location']['last_updated'] ?? null,
                        ]
                    );

                    // Ship Specs
                    if (!empty($shipData['ship_specs'])) {
                        foreach ($shipData['ship_specs'] as $spec) {
                            $ship->specs()->updateOrCreate(
                                ['name' => $spec['name']],
                                ['value' => $spec['value']]
                            );
                        }
                    }

                    // Ship Gallery
                    if (!empty($shipData['gallery'])) {
                        foreach ($shipData['gallery'] as $image) {
                            $ship->gallery()->updateOrCreate(['image' => $image]);
                        }
                    }
                }

                // Cabins
                if (!empty($tripData['cabins'])) {
                    foreach ($tripData['cabins'] as $cabinData) {
                        $cabin = $trip->cabins()->updateOrCreate(
                            ['name' => $cabinData['name']],
                            [
                                'description' => $cabinData['description'] ?? null,
                                'amount' => $cabinData['price']['amount'] ?? null,
                                'currency' => $cabinData['price']['currency'] ?? null,
                                'deck_level' => $cabinData['deck_level'] ?? null,
                                'image' => $cabinData['image'] ?? null,
                                'inclusions' => $cabinData['inclusions'] ?? null,
                                'exclusions' => $cabinData['exclusions'] ?? null,
                                'availability' => $cabinData['availability'] ?? null,
                            ]
                        );

                        // Cabin Prices
                        if (!empty($cabinData['prices'])) {
                            foreach ($cabinData['prices'] as $price) {
                                $cabin->prices()->updateOrCreate(
                                    ['amount' => $price['amount'], 'currency' => $price['currency']]
                                );
                            }
                        }
                    }
                }

                // Itinerary
                if (!empty($tripData['itinerary'])) {
                    foreach ($tripData['itinerary'] as $item) {
                        $trip->itineraries()->updateOrCreate(
                            ['day' => $item['day']],
                            [
                                'label' => $item['label'] ?? null,
                                'body' => $item['body'] ?? null,
                            ]
                        );
                    }
                }

                //  Destinations
                if (!empty($tripData['destinations'])) {
                    foreach ($tripData['destinations'] as $destinationName) {
                        $trip->destinations()->updateOrCreate(
                            [
                                // condition part
                                'trip_id' => $trip->id,   // bind with trip
                                'name' => $destinationName
                            ],
                            [
                                // update part
                                'name' => $destinationName
                            ]
                        );
                    }
                }


                //  Locations
                if (!empty($tripData['locations'])) {
                    foreach ($tripData['locations'] as $location) {
                        $trip->locations()->updateOrCreate(['name' => $location]);
                    }
                }

                //  Countries
                if (!empty($tripData['countries'])) {
                    foreach ($tripData['countries'] as $country) {
                        $trip->countrries()->updateOrCreate(['name' => $country]);
                    }
                }

                //  Trip Gallery
                if (!empty($tripData['gallery'])) {
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
}
