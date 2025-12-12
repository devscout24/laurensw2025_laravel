<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\BookingTrip;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class BookingTripApiController extends Controller
{
    use apiresponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BookingTrip::select(
            'id',
            'user_id',
            'trip_id',
            'number_of_members',
            'trip_date',
            'name',
            'surname',
            'gender',
            'date_of_birth',
            'mobile',
            'email',
            'street_house_number',
            'country',
            'post_code',
            'city_place_name',
            'stay_at_home_contact',
            'contact_no_home_caller',
            'room_preference',
            'room_category_id',
            'travel_insurance',
            'insured_at',
            'policy_number',
            'additional_note',
            'terms_condition_check'

        )->get();
        return $this->success($data, 'Success', 200);
    }
    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'trip_id'                => 'required|exists:trips,id',
                'ship_id'                => 'nullable|exists:ships,id',
                'cabin_id'               => 'nullable|exists:cabins,id',
                'number_of_members'      => 'nullable|integer|min:1',
                'name'                   => 'nullable|string|max:255',
                'surname'                => 'nullable|string|max:255',
                'gender'                 => 'nullable|in:male,female',
                'date_of_birth'          => 'nullable|date',
                'mobile'                 => 'nullable|string|max:20',
                'email'                  => 'nullable|email|max:255',
                'street_house_number'    => 'nullable|string|max:255',
                'country'                => 'nullable|string|max:255',
                'post_code'              => 'nullable|string|max:20',
                'city_place_name'        => 'nullable|string|max:255',
                'stay_at_home_contact'   => 'nullable|string|max:255',
                'contact_no_home_caller' => 'nullable|string|max:20',
                'room_preference'        => 'nullable|in:1,2,3,4',
                'travel_insurance'       => 'nullable|in:yes,no',
                'insured_at'             => 'nullable|string|max:255',
                'policy_number'          => 'nullable|string|max:255',
                'additional_note'        => 'nullable|string',
                'terms_condition_check'  => 'nullable|boolean',
            ]);

            // Cabin price handle
            $cabin = \App\Models\Cabin::find($validated['cabin_id']);
            if (! $cabin) {
                return $this->success('Cabin not found', 200, []);
            }

            // Authenticated user set
            // $validated['user_id'] = request()->user()->id;

            // Auto set total_amount from cabin price
            $validated['total_amount'] = $cabin->amount;

            // Default status if not provided
            if (! isset($validated['status'])) {
                $validated['status'] = 'pending';
            }

            // Create booking
            $booking = BookingTrip::create($validated);

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
