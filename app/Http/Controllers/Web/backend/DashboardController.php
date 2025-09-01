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


        // --- User chart data  start
        $newUsers = User::where('is_admin', 0)
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->whereYear('created_at', now()->year)
            ->get();

        // Define all months of the year
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        // Initialize all months with 0
        $userCountsByMonth = array_fill_keys($months, 0);

        // Group the users by the month they were created
        $usersGroupedByMonth = $newUsers->groupBy(function ($user) {
            return $user->created_at->format('F'); // Group by month name
        });

        // Populate the count of users in the correct month
        foreach ($usersGroupedByMonth as $month => $users) {
            $userCountsByMonth[$month] = count($users);
        }

        // Prepare chart data
        $chartData = [
            'labels' => $months,
            'data' => array_values($userCountsByMonth), // 12 values, all integers
        ];
        // dd($chartData);
        // --- User chart data end

        $totalBookings = BookingTrip::all()
            ->concat(CruiseBooking::all())
            ->concat(BookingTwo::all());



        // --- Booking chart: total bookings per month (all 3 tables)
        $bookingTables = [BookingTrip::class, CruiseBooking::class, BookingTwo::class];
        $bookingCounts = array_fill_keys($months, 0);

        foreach ($bookingTables as $model) {
            $bookings = $model::whereYear('created_at', now()->year)->get();
            $grouped = $bookings->groupBy(fn($b) => $b->created_at->format('F'));
            foreach ($grouped as $month => $bks) {
                $bookingCounts[$month] += count($bks);
            }
        }

        $bookingChartData = [
            'labels' => $months,
            'data' => array_values($bookingCounts),
        ];

        return view('backend.dashboard', compact(
            'user',
            'chartData',
            'totalBookings',
            'bookingChartData'
        ));
    }
}
