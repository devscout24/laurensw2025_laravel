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
    </div>
@endsection
