<?php

namespace App\Http\Controllers;

use App\Models\TripsTwo;
use Illuminate\Http\Request;

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

    /**
     * Import trips from API
     */
    public function importTrips()
    {
        //
    }
}
