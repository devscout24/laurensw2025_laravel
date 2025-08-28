<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\BookingTrip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BookingTripController extends Controller
{
    public function index()
    {
        $data = BookingTrip::all();
        return view('backend.layout.tazim.bookingtrip.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = BookingTrip::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('additional_note', function ($row) {
                    return Str::words(strip_tags($row->additional_note), 8, '...');
                })
                ->addColumn('date_of_birth', function ($row) {
                    return Carbon::parse($row->date_of_birth)->format('d F Y');
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a class="btn btn-sm btn-warning" href="' . route('bookingTrip.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <a class="btn btn-sm btn-info" href="' . route('bookingTrip.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                            <button type="button"  onclick="deleteData(\'' . route('bookingTrip.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['additional_note', 'action'])
                ->make(true);
        }

    }

    public function show($id)
    {
        $data = BookingTrip::find($id);
        return view('backend.layout.tazim.bookingtrip.show', compact('data'));
    }

    public function edit($id)
    {
        $data = BookingTrip::findOrFail($id);
        return view('backend.layout.tazim.bookingtrip.edit', compact('data'));
    }
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'trip_date'              => 'required|date',
    //         'name'                   => 'required|string',
    //         'surname'                => 'nullable|string',
    //         'date_of_birth'          => 'required|date',
    //         'mobile'                 => 'required|string',
    //         'email'                  => 'required|email',
    //         'street_house_number'    => 'nullable|string',
    //         'country'                => 'nullable|string',
    //         'post_code'              => 'nullable|string',
    //         'city_place_name'        => 'nullable|string',
    //         'stay_at_home_contact'   => 'nullable|string',
    //         'contact_no_home_caller' => 'nullable|string',
    //         'room_category_id'       => 'nullable|integer',
    //         'policy_number'          => 'nullable|string',
    //         'insured_at'             => 'nullable|string',
    //         'additional_note'        => 'nullable|string',
    //     ]);

    //     $booking = BookingTrip::findOrFail($id);

    //     $booking->trip_date              = $request->trip_date;
    //     $booking->name                   = $request->name;
    //     $booking->surname                = $request->surname;
    //     $booking->date_of_birth          = $request->date_of_birth;
    //     $booking->mobile                 = $request->mobile;
    //     $booking->email                  = $request->email;
    //     $booking->street_house_number    = $request->street_house_number;
    //     $booking->country                = $request->country;
    //     $booking->post_code              = $request->post_code;
    //     $booking->city_place_name        = $request->city_place_name;
    //     $booking->stay_at_home_contact   = $request->stay_at_home_contact;
    //     $booking->contact_no_home_caller = $request->contact_no_home_caller;
    //     $booking->room_category_id       = $request->room_category_id;
    //     $booking->insured_at             = $request->insured_at;
    //     $booking->policy_number          = $request->policy_number;
    //     $booking->additional_note        = $request->additional_note;

    //     $booking->number_of_members = $request->number_of_members;
    //     $booking->gender            = $request->gender;
    //     $booking->room_preference   = $request->room_preference;

    //     $booking->travel_insurance = $request->has('travel_insurance') ? 'no' : 'yes';

    //     $booking->terms_condition_check = $request->has('terms_condition_check') ? 1 : 0;

    //     $booking->save();

    //     return redirect()->route('bookingTrip.list')->with('success', 'Booking trip updated successfully.');
    // }

    public function update(BookingTripRequest $request, $id)
    {
        try {
            $booking = BookingTrip::findOrFail($id);

            $booking->trip_date              = $request->trip_date;
            $booking->name                   = $request->name;
            $booking->surname                = $request->surname;
            $booking->date_of_birth          = $request->date_of_birth;
            $booking->mobile                 = $request->mobile;
            $booking->email                  = $request->email;
            $booking->street_house_number    = $request->street_house_number;
            $booking->country                = $request->country;
            $booking->post_code              = $request->post_code;
            $booking->city_place_name        = $request->city_place_name;
            $booking->stay_at_home_contact   = $request->stay_at_home_contact;
            $booking->contact_no_home_caller = $request->contact_no_home_caller;
            $booking->room_category_id       = $request->room_category_id;
            $booking->insured_at             = $request->insured_at;
            $booking->policy_number          = $request->policy_number;
            $booking->additional_note        = $request->additional_note;

            $booking->number_of_members = $request->number_of_members;
            $booking->gender            = $request->gender;
            $booking->room_preference   = $request->room_preference;

            // If checkbox checked, set "yes", otherwise "no"
            $booking->travel_insurance = $request->has('travel_insurance') ? 'yes' : 'no';

            // Terms checkbox check
            $booking->terms_condition_check = $request->has('terms_condition_check') ? 1 : 0;

            $booking->save();

            return redirect()
                ->route('bookingTrip.list')
                ->with('success', 'Booking trip updated successfully.');

        } catch (Exception $e) {
            Log::error('BookingTrip update failed: ' . $e->getMessage(), [
                'id'    => $id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('bookingTrip.list')
                ->with('error', 'Something went wrong while updating booking trip.');
        }
    }

    public function delete($id)
    {
        $bookingTrip = BookingTrip::find($id);

        if (! $bookingTrip) {
            return back()->with('error', 'Record not found!');
        }

        if ($bookingTrip->delete()) { // Soft delete will set deleted_at
            return back()->with('success', 'Deleted Successfully');
        }

        return back()->with('error', 'Try Again!');
    }

    public function restore($id)
    {
        $bookingTrip = BookingTrip::onlyTrashed()->find($id);

        if (! $bookingTrip) {
            return back()->with('error', 'Record not found!');
        }

        if ($bookingTrip->restore()) {
            return back()->with('success', 'Restored Successfully');
        }

        return back()->with('error', 'Try Again!');
    }

}
