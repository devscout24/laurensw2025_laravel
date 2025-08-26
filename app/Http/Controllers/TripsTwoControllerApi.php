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
    public function index()
    {
        try {
            $trips = TripsTwo::with('photos')->paginate(10);
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
