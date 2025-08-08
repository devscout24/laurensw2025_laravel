@extends('backend.app')
@section('title', 'Rating Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Rating Details</h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $data->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Designation:</strong> {{ $data->designation ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Description:</strong> {{ $data->description ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Image:</strong><br>
                        @if (!empty($data->image) && file_exists(public_path($data->image)))
                            <img src="{{ asset($data->image) }}" alt="Image" width="100" height="100"
                                style="object-fit: cover;" class="rounded-circle mt-2">
                        @else
                            <span>N/A</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Rating:</strong> {{ $data->rating ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
