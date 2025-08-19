<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\BookingTrip;
use App\Traits\apiresponse;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingTripApiController extends Controller
{
    use apiresponse;
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trip_id'                => 'nullable|integer',
            'number_of_members'      => 'nullable',
            'trip_date'              => 'required',
            'name'                   => 'required|string|max:255',
            'surname'                => 'required|string|max:255',
            'gender'                 => 'required',
            'date_of_birth'          => 'required',
            'mobile'                 => 'required|string|max:20',
            'email'                  => 'required|email|max:255',
            'street_house_number'    => 'required|string|max:255',
            'country'                => 'nullable|string|max:100',
            'post_code'              => 'required|string|max:20',
            'city_place_name'        => 'required|string|max:100',
            'stay_at_home_contact'   => 'required|string|max:255',
            'contact_no_home_caller' => 'required|string|max:20',
            'room_preference'        => 'nullable|in:1 person,2/3 person',
            'room_category_id'       => 'nullable|integer',
            'travel_insurance'       => 'nullable',
            'insured_at'             => 'required|string|max:255',
            'policy_number'          => 'required|string|max:255',
            'additional_note'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Auto-generate custom trip_id like TRIP-00001
        $lastTrip = BookingTrip::orderBy('id', 'desc')->first();

        if ($lastTrip && preg_match('/TRIP-(\d+)/', $lastTrip->trip_id, $matches)) {
            $nextTripNumber = (int) $matches[1] + 1;
        } else {
            $nextTripNumber = 1;
        }

        $generatedTripId = 'TRIP-' . str_pad($nextTripNumber, 5, '0', STR_PAD_LEFT);

        $booking = new BookingTrip();
        if (auth()->check()) {
            $booking->user_id = auth()->user()->id;
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $booking->trip_id                = $generatedTripId;
        $booking->number_of_members      = $request->number_of_members;
        $booking->trip_date              = Carbon::parse($request->trip_date)->format('Y-m-d');
        $booking->date_of_birth          = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $booking->name                   = $request->name;
        $booking->surname                = $request->surname;
        $booking->gender                 = $request->gender;
        $booking->mobile                 = $request->mobile;
        $booking->email                  = $request->email;
        $booking->street_house_number    = $request->street_house_number;
        $booking->country                = $request->country;
        $booking->post_code              = $request->post_code;
        $booking->city_place_name        = $request->city_place_name;
        $booking->stay_at_home_contact   = $request->stay_at_home_contact;
        $booking->contact_no_home_caller = $request->contact_no_home_caller;
        $booking->room_preference        = $request->room_preference;
        $booking->room_category_id       = $request->room_category_id;
        $booking->travel_insurance       = $request->travel_insurance;
        $booking->insured_at             = $request->insured_at;
        $booking->policy_number          = $request->policy_number;
        $booking->additional_note        = $request->additional_note;
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Booking successful.',
            'data'    => $booking,
        ]);
    }

}
