@extends('backend.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                {{-- <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="info">
                                        <h5>{{ $greetings['message'] }} {{ auth()->user()->name }}</h5>
                                        <p class="card-text font-small-3">What's your plan today ?</p>
                                    </div>
                                    <div class="img">
                                        @if ($greetings['type'] == 'morning')
                                        <img src="{{ asset('backend/assets/greetings/004-sunrise.png') }}"
                                        alt="Gooddo Morning" />
                                        @elseif ($greetings['type'] == 'afternoon')
                                        <img src="{{ asset('backend/assets/greetings/002-sunsets.png') }}" alt="Gooddo Afternoon">
                                        @else
                                        <img src="{{ asset('backend/assets/greetings/003-cloudy-night.png') }}" alt="Gooddo Night">
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> --}}
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        {{-- Card 1 --}}
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="info">
                                        <h5>{{ $greetings['message'] }} {{ auth()->user()->name }}</h5>
                                        <p class="card-text font-small-3">What's your plan today ?</p>
                                    </div>
                                    <div class="img">
                                        @if ($greetings['type'] == 'morning')
                                            <img src="{{ asset('backend/assets/greetings/004-sunrise.png') }}"
                                                alt="Good Morning" />
                                        @elseif ($greetings['type'] == 'afternoon')
                                            <img src="{{ asset('backend/assets/greetings/002-sunsets.png') }}"
                                                alt="Good Afternoon">
                                        @else
                                            <img src="{{ asset('backend/assets/greetings/003-cloudy-night.png') }}"
                                                alt="Good Night">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Card 2 --}}
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="info">
                                        <h5>Total User</h5>
                                        <h4> {{ $user->count() ?? 0 }}</h4>
                                    </div>
                                    <i class="fas fa-user text-success font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                        {{-- Card 3 --}}
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="info">
                                        <h5>Total Bookings</h5>
                                        <h4> {{ $totalBookings ?? 0 }}</h4>
                                    </div>
                                    <i class="fas fa-plane text-success font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>

        <div class="row" style="margin-bottom: 100px;">
            <!-- Card 1 -->
            <div class="col-lg-6 col-md-12 col-12 mb-4">
                <div class="card-style mb-10">
                    <div style="background-color: white;" class="p-4 rounded-3">
                        <p class="text-primary text-bold text-center">User Data for Each Month</p>
                        <canvas id="new-users-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 mb-4">
                <div class="card-style mb-10">
                    <div style="background-color: white;" class="p-4 rounded-3">
                        <p class="text-primary text-bold text-center">Booking Data for Each Month</p>
                        <canvas id="total-booking-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- chart for new users start --}}
    <script>
        // Data passed from the controller
        const labels = @json($chartData['labels']); // Will always have 12 months
        const data = @json($chartData['data']); // Will have counts, with 0 for months without users

        const ctx = document.getElementById('new-users-chart').getContext('2d');
        const newUserChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'This year\'s Users',
                    data: data,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(0, 123, 255, 0.5)',
                        'rgba(220, 53, 69, 0.5)',
                        'rgba(40, 167, 69, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(23, 162, 184, 0.5)',
                        'rgba(255, 193, 7, 0.5)',
                        'rgba(188, 80, 144, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132,0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(0, 123, 255, 0.5)',
                        'rgba(220, 53, 69, 0.5)',
                        'rgba(40, 167, 69, 0.5)',
                        'rgba(23, 162, 184, 0.5)',
                        'rgba(255, 193, 7, 0.5)',
                        'rgba(188, 80, 144, 0.5)'
                    ],
                    borderWidth: 1,
                    barThickness: 50
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    {{-- chart for new users end --}}

    {{-- chart for All Bookings start --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = @json($bookingChartData['labels']);
            const data = @json($bookingChartData['data']);
            const ctx = document.getElementById('total-booking-chart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Bookings",
                        data: data,
                        borderColor: [
                            'rgba(255, 99, 132,0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(0, 123, 255, 0.5)',
                            'rgba(220, 53, 69, 0.5)',
                            'rgba(40, 167, 69, 0.5)',
                            'rgba(23, 162, 184, 0.5)',
                            'rgba(255, 193, 7, 0.5)',
                            'rgba(188, 80, 144, 0.5)'
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: "Total Bookings per Month (Current Year)"
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }
                }
            });
        });
    </script>
    {{-- chart for All Bookings start --}}
@endpush
