@extends('backend.app')
@section('title', 'Dynamic Button Config Create')

@section('content')
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">
    <div class="app-content content">
        <div class="row">
            @if ($data->count() < 3)
                <div class="col-lg-6 m-auto">
                    <form action="{{ route('dynamicTripButton.store') }}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="card card-body">
                            <h4 class="mb-4"> <span id="Categorytitle">Dynamic Button Config Create</span></h4>

                            <div class="row mb-2">
                                <label class="col-3 col-form-label"><i>Button Label</i></label>
                                <div class="col-9">
                                    <input type="text" name="button_name" class="form-control"
                                        placeholder="Button Name..." value="{{ old('button_name') }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-3 col-form-label"><i>Trip URL</i></label>
                                <div class="col-9">
                                    <select name="trip_url" id="trip_url" class="form-control">
                                        <option value="" selected disabled>Select Trip URL</option>

                                        {{-- Example static placeholder values, replace with API data later --}}
                                        <option value="https://example.com/trip-1"
                                            {{ old('trip_url') == 'https://example.com/trip-1' ? 'selected' : '' }}>Trip 1
                                        </option>
                                        <option value="https://example.com/trip-2"
                                            {{ old('trip_url') == 'https://example.com/trip-2' ? 'selected' : '' }}>Trip 2
                                        </option>
                                        <option value="https://example.com/trip-3"
                                            {{ old('trip_url') == 'https://example.com/trip-3' ? 'selected' : '' }}>Trip 3
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-3 col-form-label"><i>Trip ID</i></label>
                                <div class="col-9">
                                    <select name="trip_id" id="" class="form-control" value="{{ old('trip_id') }}">
                                        <option value="" selected disabled>Select Trip ID</option>
                                        <option value="1" {{ old('trip_id') == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ old('trip_id') == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ old('trip_id') == '3' ? 'selected' : '' }}>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success mt-2">
                                            <i class="ri-save-line"></i> Create
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
