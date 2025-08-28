<?php

namespace App\Http\Controllers;

use App\Models\TripsTwo;
use Illuminate\Http\Request;
use App\Traits\apiresponse;

class TripsTwoControllerApi extends Controller
{
    use apiresponse;

    /**
     * Retrieves all trips data.
     */
    public function index(Request $request)
    {
        try {
            $query = TripsTwo::with(['photos', 'destinationsTwos']);

            // Filter by destination
            if ($request->has('destinations')) {
                $destination = $request->input('destinations');
                $query->whereHas('destinationsTwos', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            // Add more filters if needed (ship_name, region, etc.)
            if ($request->has('ship_name')) {
                $query->where('ship_name', 'like', '%' . $request->ship_name . '%');
            }

            if ($request->has('region')) {
                $query->where('region', 'like', '%' . $request->region . '%');
            }
            if ($request->has('departure_date')) {
                $query->where('departure_date', 'like', '%' . $request->departure_date . '%');
            }

            // Paginate results
            $trips = $query->paginate(9);

            // If no results found, return success with empty array
            if ($trips->isEmpty()) {
                return $this->success(
                    ['trips' => []],
                    'No trips found with given filters.',
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
     * Shows all trips details (id wise).
     */
    public function showDetails($id)
    {
        try {
            $trip = TripsTwo::with([
                'photos',
                'cabinsTwos',
                'extras',
                'destinationsTwos',
                'itinerariesTwos'
            ])->findOrFail($id);

            return $this->success(
                ['trip' => $trip],
                'Trip Details retrieved successfully!',
                200
            );
        } catch (\Exception $e) {
            return $this->error(
                'Failed to retrieve trip.',
                $e->getMessage(),
                500
            );
        }
    }
}
