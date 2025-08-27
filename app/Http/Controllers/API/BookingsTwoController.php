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
    /* public function store(Request $request)
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
    } */

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'trips_two_id'          => 'required|exists:trips_twos,id',
                'cabin_two_id'          => 'nullable|exists:cabin_twos,id',
                'number_of_members'     => 'nullable|integer|min:1',
                'name'                  => 'nullable|string|max:255',
                'surname'               => 'nullable|string|max:255',
                'gender'                => 'nullable|in:male,female',
                'date_of_birth'         => 'nullable|date',
                'mobile'                => 'nullable|string|max:20',
                'email'                 => 'nullable|email|max:255',
                'street_house_number'   => 'nullable|string|max:255',
                'country'               => 'nullable|string|max:255',
                'post_code'             => 'nullable|string|max:20',
                'city_place_name'       => 'nullable|string|max:255',
                'stay_at_home_contact'  => 'nullable|string|max:255',
                'contact_no_home_caller' => 'nullable|string|max:20',
                'room_preference'       => 'nullable|in:1,2,3,4',
                'travel_insurance'      => 'nullable|in:yes,no',
                'insured_at'            => 'nullable|string|max:255',
                'policy_number'         => 'nullable|string|max:255',
                'additional_note'       => 'nullable|string',
                'terms_condition_check' => 'nullable|boolean',
            ]);

            // Cabin price handle
            $cabin = \App\Models\CabinTwo::find($validated['cabin_two_id']);
            if (!$cabin) {
                return $this->success('Cabin not found', 200, []);
            }

            // Authenticated user set
            $validated['user_id'] = request()->user()->id;

            // Auto set total_amount from cabin price
            $validated['total_amount'] = $cabin->price;

            // Default status if not provided
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
