<?php

namespace App\Http\Controllers\API;

use App\Models\BookingTwo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\apiresponse;

class BookingsTwoController extends Controller
{
    use apiresponse;

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'trips_two_id' => 'required|exists:trips_twos,id',
                'cabin_two_id' => 'nullable|exists:cabin_twos,id',
            ]);

            // Get the cabin to find its price
            $cabin = \App\Models\CabinTwo::find($validated['cabin_two_id']);

            if (!$cabin) {
                return $this->error('Cabin not found', null, 404);
            }
            // Set authenticated user
            $validated['user_id'] = auth()->id();

            // Automatically set total_amount = cabin price
            $validated['total_amount'] = $cabin->price;

            if (!isset($validated['status'])) {
                $validated['status'] = 'pending';
            }
            // Create booking
            $booking = BookingTwo::create($validated);

            return $this->success(
                ['booking' => $booking],
                'Booking created successfully!',
                201
            );
        } catch (\Exception $e) {
            return $this->error(
                'Failed to create booking.',
                $e->getMessage(),
                500
            );
        }
    }
}
