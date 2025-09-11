<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Trip;
use App\Models\Socialmedia;
use App\Traits\apiresponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PriceWiseSortController extends Controller
{
    use apiresponse;

    /**
     * Get Trips sorted by price high to low and low to high
     */

    public function sorting(Request $request)
    {
        try {
            $order = $request->query('order', 'desc');
            $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

            $query = Trip::with([
                'ship.specs',
                'ship.gallery',
                'cabins',
                'itineraries',
                'destinations',
                'locations',
                'countrries',
                'gallery',
            ])
                ->addSelect([
                    'trip_amount' => DB::table('cabins')
                        ->select(DB::raw('MAX(amount)'))
                        ->whereColumn('cabins.trip_id', 'trips.id')
                ])
                ->orderBy('trip_amount', $order)
                ->get();

            return $this->success(
                ['trips' => $query],
                "Trips sorted by cabin amount ({$order}) successfully!",
                200
            );
        } catch (\Exception $e) {
            return $this->error(
                'Failed to sort trips.',
                $e->getMessage()
            );
        }
    }
}
