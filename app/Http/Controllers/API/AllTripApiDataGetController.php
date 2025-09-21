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

            // 2. Cruises
            $cruises = Cruise::with([
                'days.images',
                'cabins',
                'highlights',
                'notes',
                'offers',
            ])->get();

            // 3. TripsTwo
            $tripsTwo = TripsTwo::with(['photos', 'destinationsTwos'])->get();

            // 4. Merge all data collections together
            $allData = collect()
                ->merge($trips)
                ->merge($cruises)
                ->merge($tripsTwo);

            // Apply sorting (e.g. by departure_date)
            $allData = $allData->sortByDesc('created_at'); // example

            // 5. Pagination apply
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

            // 6. Response
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
