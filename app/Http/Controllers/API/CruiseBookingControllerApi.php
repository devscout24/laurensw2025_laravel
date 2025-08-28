<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cruise;
use App\Models\CruiseCabin;
use App\Traits\apiresponse;
use App\Models\CruiseBooking;
use Illuminate\Support\Facades\Auth;

class CruiseBookingControllerApi extends Controller
{
    use apiresponse;

    /**
     * Store a newly created Cruise Booking in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'cruise_id' => 'required|exists:cruises,id',
                'cruise_cabin_id' => 'required|exists:cruise_cabins,id',
                'number_of_members' => 'required|integer|min:1',
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'gender' => 'nullable|in:male,female',
                'date_of_birth' => 'nullable|date',
                'mobile' => 'required|string|max:20',
                'email' => 'required|email',
                'street_house_number' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'post_code' => 'nullable|string|max:20',
                'city_place_name' => 'nullable|string|max:255',
                'stay_at_home_contact' => 'nullable|string|max:255',
                'contact_no_home_caller' => 'nullable|string|max:20',
                'room_preference' => 'nullable|in:1,2,3,4',
                'travel_insurance' => 'nullable|in:yes,no',
                'insured_at' => 'nullable|string|max:255',
                'policy_number' => 'nullable|string|max:255',
                'additional_note' => 'nullable|string',
                'terms_condition_check' => 'required|boolean',
            ]);

            // Find Cruise Cabin
            $cabin = Cruise::find($validated['cruise_id']);
            if (!$cabin) {
                return $this->success([], 'Cruise Did not Found', 200);
            }

            // Find Cruise Cabin
            $cabin = CruiseCabin::find($validated['cruise_cabin_id']);
            if (!$cabin) {
                return $this->success([], 'Cruise Cabin Did not Found', 200);
            }

            // The cabin must be part of the cruise
            if ($cabin->cruise_id != $validated['cruise_id']) {
                return $this->success([], 'Selected cabin does not belong to the chosen cruise.', 200);
            }

            // total_amount auto set.
            $validated['total_amount'] = $cabin->price_with_discount;
            $validated['user_id'] = Auth::id();

            // Default status if not provided
            if (!isset($validated['status'])) {
                $validated['status'] = 'pending';
            }

            $booking = CruiseBooking::create($validated);

            return $this->success(
                ['booking' => $booking->load(['cruise', 'cabin'])],
                'Cruise Booking created successfully!',
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
