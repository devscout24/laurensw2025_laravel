@extends('backend.app')
@section('title', 'Edit Booking Trip')

@section('content')
<div class="app-content content">
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <form action="{{ route('bookingTrip.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card card-body">
                        <h4 class="mb-3">Edit Booking Trip</h4>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Trip ID</label>
                            <div class="col-md-8">
                                <input type="text" name="trip_id" class="form-control" value="{{ old('trip_id', $data->trip_id) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Number of Members</label>
                            <div class="col-md-8">
                                @foreach([1, 2, 3, 4] as $num)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="number_of_members" value="{{ $num }}" {{ $data->number_of_members == $num ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $num }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Trip Date</label>
                            <div class="col-md-8">
                                <input type="date" name="trip_date" class="form-control" value="{{ old('trip_date', $data->trip_date) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Name</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control" value="{{ old('name', $data->name) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Surname</label>
                            <div class="col-md-8">
                                <input type="text" name="surname" class="form-control" value="{{ old('surname', $data->surname) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Gender</label>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="male" {{ $data->gender == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female" {{ $data->gender == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Date of Birth</label>
                            <div class="col-md-8">
                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $data->date_of_birth) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Mobile</label>
                            <div class="col-md-8">
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $data->mobile) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Email</label>
                            <div class="col-md-8">
                                <input type="email" name="email" class="form-control" value="{{ old('email', $data->email) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Street/House Number</label>
                            <div class="col-md-8">
                                <input type="text" name="street_house_number" class="form-control" value="{{ old('street_house_number', $data->street_house_number) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Country</label>
                            <div class="col-md-8">
                                <input type="text" name="country" class="form-control" value="{{ old('country', $data->country) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Post Code</label>
                            <div class="col-md-8">
                                <input type="text" name="post_code" class="form-control" value="{{ old('post_code', $data->post_code) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">City/Place Name</label>
                            <div class="col-md-8">
                                <input type="text" name="city_place_name" class="form-control" value="{{ old('city_place_name', $data->city_place_name) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Stay at Home Contact</label>
                            <div class="col-md-8">
                                <input type="text" name="stay_at_home_contact" class="form-control" value="{{ old('stay_at_home_contact', $data->stay_at_home_contact) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Contact No (Home Caller)</label>
                            <div class="col-md-8">
                                <input type="text" name="contact_no_home_caller" class="form-control" value="{{ old('contact_no_home_caller', $data->contact_no_home_caller) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Room Preference</label>
                            <div class="col-md-8">
                                @foreach(['1 person', '2/3 person'] as $option)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="room_preference" value="{{ $option }}" {{ $data->room_preference == $option ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Room Category ID</label>
                            <div class="col-md-8">
                                <input type="text" name="room_category_id" class="form-control" value="{{ old('room_category_id', $data->room_category_id) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Travel Insurance</label>
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input type="checkbox" name="travel_insurance" class="form-check-input" id="travel_insurance"
                                        value="no" {{ $data->travel_insurance == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="travel_insurance">I don't have travel insurance yet</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Insured At</label>
                            <div class="col-md-8">
                                <input type="text" name="insured_at" class="form-control" value="{{ old('insured_at', $data->insured_at) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-md-4 col-form-label">Policy Number</label>
                            <div class="col-md-8">
                                <input type="text" name="policy_number" class="form-control" value="{{ old('policy_number', $data->policy_number) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Additional Note</label>
                            <div class="col-md-8">
                                <textarea name="additional_note" class="form-control" rows="3">{{ old('additional_note', $data->additional_note) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="terms_condition_check" class="form-check-input" id="terms_condition_check" value="1"
                                        {{ $data->terms_condition_check ? 'checked' : '' }}>
                                    <label class="form-check-label" for="terms_condition_check">
                                        I agree to the terms and conditions
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="ri-save-line"></i> Update Booking
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
