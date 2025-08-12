@extends('backend.app')
@section('title', 'Dynamic Button Config Edit')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('dynamicTripButton.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4"><span id="Categorytitle">Dynamic Button Config</span></h4>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Button Label</i></label>
                            <div class="col-9">
                                <input type="text" name="button_name" class="form-control" placeholder="Button Name..."
                                    value="{{ old('button_name', $data->button_name) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Trip URL</i></label>
                            <div class="col-9">
                                <select name="trip_url" id="trip_url" class="form-control">
                                    <option value="" disabled>Select Trip URL</option>
                                    <option value="https://example.com/trip-1"
                                        {{ old('trip_url', $data->trip_url ?? '') == 'https://example.com/trip-1' ? 'selected' : '' }}>
                                        Trip 1
                                    </option>
                                    <option value="https://example.com/trip-2"
                                        {{ old('trip_url', $data->trip_url ?? '') == 'https://example.com/trip-2' ? 'selected' : '' }}>
                                        Trip 2
                                    </option>
                                    <option value="https://example.com/trip-3"
                                        {{ old('trip_url', $data->trip_url ?? '') == 'https://example.com/trip-3' ? 'selected' : '' }}>
                                        Trip 3
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Trip ID</i></label>
                            <div class="col-9">
                                <select name="trip_id" id="trip_id" class="form-control">
                                    <option value="" disabled {{ old('trip_id', $data->trip_id) ? '' : 'selected' }}>
                                        Select Trip ID
                                    </option>
                                    <option value="1" {{ old('trip_id', $data->trip_id) == '1' ? 'selected' : '' }}>1
                                    </option>
                                    <option value="2" {{ old('trip_id', $data->trip_id) == '2' ? 'selected' : '' }}>2
                                    </option>
                                    <option value="3" {{ old('trip_id', $data->trip_id) == '3' ? 'selected' : '' }}>3
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary mt-2">
                                        <i class="ri-save-line"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
