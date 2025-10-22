<?php

namespace App\Http\Controllers\API;

use App\Models\Trip;
use App\Models\Cruise;
use App\Models\TripsTwo;
use App\Traits\apiresponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class AllTripApiDataGetController extends Controller
{
    use apiresponse;
    /**
     * Retrieves all travel data (trips, cruises, trips two) for the frontend.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    /* public function getAllTripsData(Request $request)
    {
        try {
            // 1. Trips
            $trips = Trip::with([
                'ship.specs',
                'ship.gallery',
                'cabins',
                'cabins.prices',
                'itineraries',
                'destinations',
                'locations',
                'countrries',
                'gallery',
            ])->get();

            // Add custom property to each trip
            $trips->map(function ($trip) {
                $trip->trip_type = 'trip_one';
                return $trip;
            });

            // 2. TripsTwo
            $tripsTwo = TripsTwo::with(['photos', 'destinationsTwos','cabinsTwos'])->get();

            // Add custom property to each tripTwo
            $tripsTwo->map(function ($tripTwo) {
                $tripTwo->trip_type = 'trip_two';
                return $tripTwo;
            });


            // 3. Merge all data collections together
            $allData = collect()
                ->merge($trips)
                ->merge($tripsTwo);

            // Apply sorting (e.g. by departure_date)
            $allData = $allData->sortByDesc('created_at'); // example

            // 4. Pagination apply
            $perPage = $request->input('per_page', 9);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $allData->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $paginatedData = new LengthAwarePaginator(
                $currentItems,
                $allData->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // 5. Response
            return $this->success(
                ['trips' => $paginatedData],
                'All trips data retrieved successfully!',
                200
            );
        } catch (\Exception $e) {
            return $this->error(
                'Failed to retrieve trips data.',
                $e->getMessage(),
                500
            );
        }
    } */

    public function getAllTripsData(Request $request)
    {
        try {
            // Get filters from query params
            $destination = $request->input('destinations');
            $shipName = $request->input('ship_name');
            $minDuration = $request->input('min_duration');
            $maxDuration = $request->input('max_duration');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');

            // === 1. Trip One (Trip Model) ===
            $tripsQuery = Trip::with([
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

            // Apply destination filter for Trip
            if ($destination) {
                $tripsQuery->whereHas('destinations', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            // Apply ship name filter for Trip (related model)
            if ($shipName) {
                $tripsQuery->whereHas('ship', function ($q) use ($shipName) {
                    $q->where('name', 'like', '%' . $shipName . '%');
                });
            }

            // Duration range filter (Trip)
            if ($minDuration && $maxDuration) {
                $tripsQuery->whereBetween('duration', [$minDuration, $maxDuration]);
            } elseif ($minDuration) {
                $tripsQuery->where('duration', '>=', $minDuration);
            } elseif ($maxDuration) {
                $tripsQuery->where('duration', '<=', $maxDuration);
            }

            // Filter by cabin price (Trip - cabins.prices)
            if ($minPrice && $maxPrice) {
                $tripsQuery->whereHas('cabins.prices', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('amount', [$minPrice, $maxPrice]);
                });

                $tripsQuery->with(['cabins' => function ($q) use ($minPrice, $maxPrice) {
                    $q->whereHas('prices', function ($p) use ($minPrice, $maxPrice) {
                        $p->whereBetween('amount', [$minPrice, $maxPrice]);
                    });
                }, 'cabins.prices' => function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('amount', [$minPrice, $maxPrice]);
                }]);
            } else {
                $tripsQuery->with(['cabins', 'cabins.prices']);
            }

            // Execute query for Trip
            $trips = $tripsQuery->get()->map(function ($trip) {
                $trip->trip_type = 'trip_one';
                return $trip;
            });

            // === 2. Trip Two (TripsTwo Model) ===
            $tripsTwoQuery = TripsTwo::with([
                'photos',
                'destinationsTwos',
                'cabinsTwos',
                'extras',
                'itinerariesTwos'
            ]);

            // Apply destination filter for TripsTwo
            if ($destination) {
                $tripsTwoQuery->whereHas('destinationsTwos', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            // Apply ship name filter for TripsTwo (direct column)
            if ($shipName) {
                $tripsTwoQuery->where('ship_name', 'like', '%' . $shipName . '%');
            }

            // Filter by cabin price (TripsTwo - cabinsTwos.price)
            if ($minPrice && $maxPrice) {
                $tripsTwoQuery->whereHas('cabinsTwos', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('price', [$minPrice, $maxPrice]);
                });

                $tripsTwoQuery->with(['cabinsTwos' => function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('price', [$minPrice, $maxPrice]);
                }]);
            } else {
                $tripsTwoQuery->with('cabinsTwos');
            }


            //execute query for TripsTwo
            $tripsTwo = $tripsTwoQuery->get()->map(function ($tripTwo) {
                $tripTwo->trip_type = 'trip_two';
                return $tripTwo;
            });

            // === 3. Merge and Sort All Trips ===
            $allTrips = collect()
                ->merge($trips)
                ->merge($tripsTwo)
                ->sortByDesc('created_at')
                ->values();

            // === 4. Pagination ===
            $perPage = $request->input('per_page', 9);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $allTrips->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $paginatedData = new LengthAwarePaginator(
                $currentItems,
                $allTrips->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // === 5. Return Response ===
            return $this->success(
                ['trips' => $paginatedData],
                'All trips data retrieved successfully!',
                200
            );
        } catch (\Exception $e) {
            return $this->error(
                'Failed to retrieve trips data.',
                $e->getMessage(),
                500
            );
        }
    }
}
