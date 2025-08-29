@extends('backend.app')

@section('title', 'Trip Booking Details')

@section('content')
    <div class="app-content content">
        <div class="container-fluid mt-5">
            <div class="card card-body">
                <div class="d-flex justify-content-center">
                    <h4>Cruise/Ship Booking Details</h4>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Booked By:</strong> {{ $booking->name ?? 'N/A' }} {{ $booking->surname ?? 'N/A' }} <br>
                        <strong>Registration Wise Name:</strong> {{ $booking->user->name ?? 'N/A' }}
                        ({{ $booking->user->email ?? 'N/A' }})
                    </div>
                    <div class="col-md-6">
                        <strong>Cruise/Ship Name:</strong> {{ $booking->cruise->name ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Start Date:</strong> {{ $booking->tripTwo->start_date ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>End Date:</strong> {{ $booking->cruise->end_date ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong> {{ ucfirst($booking->status) }}
                    </div>
                    <div class="col-md-6">
                        <strong>Booking Date:</strong> {{ $booking->created_at ?? 'N/A' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cabin:</strong> {{ $booking->cabib->name ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Price:</strong> {{ $booking->cabin->price ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Price With Discount:</strong> {{ $booking->total_amount ?? 'N/A' }}
                    </div>
                </div>
                <hr>
                <div>
                    <h5>Days</h5>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($booking->cruise->days as $day)
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-header">
                                            {{ $day->title ?? '' }}
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($day->images as $img)
                                                    <div class="col-md-4">
                                                        <img src="{{ $img->image_url ?? '' }}" class="img-fluid"
                                                            alt="Day Image" style="height: 150px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr>
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
                <div>
                    <h5>Booking Preferences</h5>
                </div>
                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Room Preference:</strong> {{ $booking->room_preference ?? '' }} Perticipants
                    </div>
                    <div class="col-md-6">
                        <strong>Travel Insurance:</strong> {{ ucfirst($booking->travel_insurance) ?? '' }}
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
                <div class="text-right">
                    <a href="{{ route('booking.cruise.index') }}" class="btn btn-primary">
                        <i data-feather="arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
