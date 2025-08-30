<?php

namespace App\Http\Controllers\Web\backend;

use App\Models\User;
use App\Models\BookingTwo;
use App\Models\BookingTrip;
use Illuminate\Http\Request;
use App\Models\CruiseBooking;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display Admin Panel
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = User::where('is_admin', 0)
            ->where('status', 'active')
            ->whereNull('deleted_at')->get();

        $bookingTripCount   = BookingTrip::count();
        $cruiseBookingCount = CruiseBooking::count();
        $bookingTwoCount    = BookingTwo::count();

        $totalBookings = $bookingTripCount + $cruiseBookingCount + $bookingTwoCount;

        return view('backend.dashboard', compact('user', 'totalBookings'));
    }
}
