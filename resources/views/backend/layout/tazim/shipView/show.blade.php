@extends('backend.app')
@section('title', 'Ship Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Ship Details</h3>

                <div class="row mb-3 m-auto">
                    <div class="col-md-6">
                        <strong>Image:</strong><br>
                        @if (!empty($data->image) && file_exists(public_path($data->image)))
                            <img src="{{ asset($data->image) }}" alt="Ship Image" width="650" height="350"
                                style="object-fit: cover;" class="rounded mt-2">
                        @else
                            <span>N/A</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $data->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Description:</strong> {{ $data->description ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Build Year:</strong> {{ $data->build_year ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Crew Number:</strong> {{ $data->crew_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Max Guest:</strong> {{ $data->max_guests ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Length:</strong> {{ $data->length ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Zodiac Boats:</strong> {{ $data->zodiac_boats ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Capacity:</strong> {{ $data->capacity ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Comfort Level:</strong> {{ $data->comfort_level ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Price:</strong> {{ $data->price ?? 'N/A' }}
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('shipView.index') }}" class="btn btn-primary"><i data-feather="arrow-left"></i>
                        Back</a>
                </div>
                <br>
            </div>
        </div>
    </div>
@endsection
