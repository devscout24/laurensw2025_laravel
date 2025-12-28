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

    //query optimize data
    /* public function getAllTripsData(Request $request)
    {
        try {
            // Get filters from query params
            $destination = $request->input('destinations');
            $shipName = $request->input('ship_name');
            $minDuration = $request->input('min_duration');
            $maxDuration = $request->input('max_duration');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $departureDate = $request->input('departure_date');

            // === 1. Trip One (Trip Model) ===
            $tripsQuery = Trip::with([
                'ship.specs',
                'ship.gallery',
                'cabins.prices', // Eager loading prices with cabins
                'itineraries',
                'destinations',
                'locations',
                'countrry',
                'gallery',
            ]);

            // Apply filters
            if ($destination) {
                $tripsQuery->whereHas('destinations', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            if ($shipName) {
                $tripsQuery->whereHas('ship', function ($q) use ($shipName) {
                    $q->where('name', 'like', '%' . $shipName . '%');
                });
            }

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
            }

            if ($departureDate) {
                $tripsQuery->whereDate('departure_date', '>=', $departureDate);
            }

            // Execute query for Trip
            $trips = $tripsQuery->get(); // Eager load data in one query

            // === 2. Trip Two (TripsTwo Model) ===
            $tripsTwoQuery = TripsTwo::with([
                'photos',
                'destinationsTwos',
                'cabinsTwos',
                'extras',
                'itinerariesTwos'
            ]);

            // Apply filters for tripsTwo
            if ($destination) {
                $tripsTwoQuery->whereHas('destinationsTwos', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            if ($shipName) {
                $tripsTwoQuery->where('ship_name', 'like', '%' . $shipName . '%');
            }

            if ($minPrice && $maxPrice) {
                $tripsTwoQuery->whereHas('cabinsTwos', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('price', [$minPrice, $maxPrice]);
                });
            }

            if ($departureDate) {
                $tripsTwoQuery->whereDate('departure_date', '>=', $departureDate);
            }

            // Execute query for TripsTwo
            $tripsTwo = $tripsTwoQuery->get(); // Eager load data for TripsTwo

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
    } */

    public function getAllTripsData(Request $request)
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
            $tripsTwo = TripsTwo::with(['photos', 'destinationsTwos', 'cabinsTwos'])->get();

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
    }
}
