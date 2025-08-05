@extends('backend.app')
@section('title', 'Customer Message Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Client Booking Details</h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Trip ID:</strong> {{ $data->trip_id ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Number of Members:</strong> {{ $data->number_of_members ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Trip Date:</strong> {{ $data->trip_date ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $data->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Surname:</strong> {{ $data->surname ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Gender:</strong> {{ $data->gender ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Date of Birth:</strong> {{ $data->date_of_birth ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Mobile:</strong> {{ $data->mobile ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Email:</strong> {{ $data->email ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Street/House Number:</strong> {{ $data->street_house_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Country:</strong> {{ $data->country ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Post Code:</strong> {{ $data->post_code ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>City/Place Name:</strong> {{ $data->city_place_name ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Stay at Home Contact:</strong> {{ $data->stay_at_home_contact ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Contact No (Home Caller):</strong> {{ $data->contact_no_home_caller ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Room Preference:</strong> {{ $data->room_preference ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Room Category ID:</strong> {{ $data->room_category_id ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Travel Insurance:</strong> {{ $data->travel_insurance ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Insured At:</strong> {{ $data->insured_at ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Policy Number:</strong> {{ $data->policy_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Additional Note:</strong><br>
                        {!! nl2br(e($data->additional_note ?? 'N/A')) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
