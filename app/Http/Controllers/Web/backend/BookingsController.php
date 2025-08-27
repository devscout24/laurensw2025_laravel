<?php

namespace App\Http\Controllers\Web\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingTrip;
use Illuminate\Http\Request;
use App\Helper\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;


class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BookingTrip::latest()->with(['user', 'trip', 'ship', 'cabin'])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    return $data->name . ' (' . ($data->user ? $data->user->name : '') . ')';
                })
                ->addColumn('email', function ($data) {
                    return $data->user ? $data->email : '';
                })
                ->addColumn('phone', function ($data) {
                    return $data->user ? $data->mobile : '';
                })
                ->addColumn('trip', function ($data) {
                    return $data->trip ? $data->trip->name : '';
                })
                ->addColumn('cabin', function ($data) {
                    return $data->cabin ? $data->cabin->name : '';
                })
                ->addColumn('status', function ($data) {
                    $statuses = ['pending', 'approved', 'cancelled'];
                    $html = '<select class="form-select" onchange="updateBookingStatus(' . $data->id . ', this.value)">';
                    foreach ($statuses as $status) {
                        $selected = $data->status === $status ? 'selected' : '';
                        $html .= '<option value="' . $status . '" ' . $selected . '>' . ucfirst($status) . '</option>';
                    }
                    $html .= '</select>';
                    return $html;
                })

                ->addColumn('total_amount', function ($data) {
                    return $data->total_amount ?? 0;
                })
                ->addColumn('date', function ($data) {
                    return $data->created_at ? $data->created_at->format('Y-m-d') : '';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                 <a href="' . route('bookings.show', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                  <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    }
                ])
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.layout.tazim.bookingtrip.index');
    }

    /**
     * Status update.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $booking = BookingTrip::findOrFail($id);
            $booking->status = $request->status;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Booking show
     */
    public function show($id)
    {
        // Booking with user, trip, cabin
        $booking = BookingTrip::with([
            'user',
            'trip',
            'ship',
            'cabin'
        ])->findOrFail($id);

        return view('backend.layout.tazim.bookingtrip.show', compact('booking'));
    }


    /**
     * Remove the specified Booking from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = BookingTrip::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Booking.',
            ]);
        }
    }
}
