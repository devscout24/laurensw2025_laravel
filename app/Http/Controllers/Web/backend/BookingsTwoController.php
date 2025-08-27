<?php

namespace App\Http\Controllers\Web\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingTwo;
use Illuminate\Http\Request;
use App\Helper\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;

class BookingsTwoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BookingTwo::latest()->with(['user', 'tripTwo', 'cabinTwo'])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    return $data->user ? $data->user->name : '';
                })
                ->addColumn('trip', function ($data) {
                    return $data->tripTwo ? $data->tripTwo->name : '';
                })
                ->addColumn('cabin', function ($data) {
                    return $data->cabinTwo ? $data->cabinTwo->title : '';
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
                    return $data->total_amount;
                })
               ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
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

        return view('backend.layout.booking-two.index');
    }

    /**
     * Status update.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $booking = BookingTwo::findOrFail($id);
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
     * Remove the specified Booking from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = BookingTwo::findOrFail($id);
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
