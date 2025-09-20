<?php

namespace App\Http\Controllers\API;

use App\Models\Trip;
use App\Models\Cruise;
use App\Models\TripsTwo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\apiresponse;

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
            // Trips One
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

            if ($request->has('destinations')) {
                $destination = $request->input('destinations');
                $tripsQuery->whereHas('destinations', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            if ($request->has('min_duration') && $request->has('max_duration')) {
                $tripsQuery->whereBetween('duration', [$request->min_duration, $request->max_duration]);
            }

            if ($request->has('departure_date')) {
                $tripsQuery->whereDate('departure_date', '>=', $request->departure_date);
            }

            if ($request->has('ship')) {
                $shipName = $request->ship;
                $tripsQuery->whereHas('ship', function ($q) use ($shipName) {
                    $q->where('name', 'like', '%' . $shipName . '%');
                });
            }

            $perPage = $request->input('per_page', 9);
            $trips = $tripsQuery->paginate($perPage);

            // Cruises
            $cruises = Cruise::with([
                'days.images',
                'cabins',
                'highlights',
                'notes',
                'offers',
            ])->paginate(9);

            // Trips Two
            $tripsTwoQuery = TripsTwo::with(['photos', 'destinationsTwos']);

            if ($request->has('destinations')) {
                $destination = $request->input('destinations');
                $tripsTwoQuery->whereHas('destinationsTwos', function ($q) use ($destination) {
                    $q->where('name', 'like', '%' . $destination . '%');
                });
            }

            if ($request->has('ship_name')) {
                $tripsTwoQuery->where('ship_name', 'like', '%' . $request->ship_name . '%');
            }

            if ($request->has('region')) {
                $tripsTwoQuery->where('region', 'like', '%' . $request->region . '%');
            }

            if ($request->has('departure_date')) {
                $tripsTwoQuery->where('departure_date', 'like', '%' . $request->departure_date . '%');
            }

            $tripsTwo = $tripsTwoQuery->paginate(9);

            // Final response
            return $this->success(
                [
                    'heritage_expeditions_trips'     => $trips,
                    'poseidons_cruises(ships)'   => $cruises,
                    'oceanwide_expedition_trips' => $tripsTwo,
                ],
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
