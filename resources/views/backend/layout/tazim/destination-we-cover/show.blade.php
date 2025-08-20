@extends('backend.app')
@section('title', 'Destination Covering Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Destination Covering Details</h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Image:</strong>
                        @if (!empty($data->image))
                            <div class="mt-2">
                                <img src="{{ asset($data->image) }}" alt="Image " width="150" height="150"
                                    class="rounded-circle" style="object-fit: cover;">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Title:</strong> {{ $data->title ?? 'N/A' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>URL:</strong> {{ $data->url ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
