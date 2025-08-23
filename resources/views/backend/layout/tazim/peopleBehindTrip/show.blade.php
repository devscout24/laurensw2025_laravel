@extends('backend.app')
@section('title', 'People Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">{{ strtoupper($data->name ?? 'N/A') }} Details</h3>

                <div class="col-md-4">
                    <!-- Avatar -->
                    <img src="{{ asset($data->image) ?? '' }}" class="img-fluid rounded-circle" width="150">
                </div>

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
            </div>
        </div>
    </div>
@endsection
