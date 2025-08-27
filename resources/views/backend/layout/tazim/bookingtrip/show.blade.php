@extends('backend.app')

@section('title', 'Trip Booking Details')

@section('content')
    <div class="app-content content">
        <div class="container-fluid mt-5">
            <div class="card card-body">

                <div class="d-flex justify-content-center mb-3">
                    <h4>Booking Details</h4>
                </div>
                <hr>

                {{-- Booking & User Info --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Booked By:</strong> {{ $booking->name ?? 'N/A' }} {{ $booking->surname ?? 'N/A' }}<br>
                        <strong>Registration Name:</strong> {{ $booking->user->name ?? 'N/A' }}
                        ({{ $booking->user->email ?? 'N/A' }})
                    </div>
                    <div class="col-md-6">
                        <strong>Trip Name:</strong> {{ $booking->trip->name ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Trip Departure Date:</strong> {{ $booking->trip->departure_date ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Trip Return Date:</strong> {{ $booking->trip->return_date ?? 'N/A' }}
                    </div>
                </div>

                {{-- Booking Status --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong> {{ ucfirst($booking->status) }}
                    </div>
                    <div class="col-md-6">
                        <strong>Booking Date:</strong> {{ $booking->created_at ?? 'N/A' }}
                    </div>
                </div>

                {{-- Cabin & Ship Info --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cabin:</strong> {{ $booking->cabin->name ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Cabin Price:</strong> {{ $booking->total_amount ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Ship Name:</strong> {{ $booking->ship->name ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Ship Description:</strong> {!! $booking->ship->description ?? 'N/A' !!}
                    </div>
                </div>
                <hr>

                {{-- Passenger Details --}}
                <div>
                    <h5>Passenger Details</h5>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $booking->name ?? '' }} {{ $booking->surname ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Gender:</strong> {{ ucfirst($booking->gender ?? '') }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Date of Birth:</strong> {{ $booking->date_of_birth ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Mobile:</strong> {{ $booking->mobile ?? '' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Email:</strong> {{ $booking->email ?? '' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Address:</strong> {{ $booking->street_house_number ?? '' }},
                        {{ $booking->city_place_name ?? '' }}, {{ $booking->country ?? '' }} -
                        {{ $booking->post_code ?? '' }}
                    </div>
                </div>
                <hr>

                {{-- Booking Preferences --}}
                <div>
                    <h5>Booking Preferences</h5>
                </div>
                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Room Preference:</strong> {{ $booking->room_preference }} Participants
                    </div>
                    <div class="col-md-6">
                        <strong>Travel Insurance:</strong> {{ ucfirst($booking->travel_insurance) }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Insured At:</strong> {{ $booking->insured_at ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Policy Number:</strong> {{ $booking->policy_number ?? '' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Additional Note:</strong> {{ $booking->additional_note ?? '' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Terms Accepted:</strong> {{ $booking->terms_condition_check ? 'Yes' : 'No' }}
                    </div>
                </div>

                {{-- Back Button --}}
                <div class="text-right">
                    <a href="{{ route('bookings.index') }}" class="btn btn-primary">
                        <i data-feather="arrow-left"></i> Back
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
