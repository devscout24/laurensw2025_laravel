@extends('backend.app')
@section('title', 'Cabin Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Cabin Details</h3>
                @php
                    $cabinTypes = [
                        'oceanview'  => 'Ocean View',
                        'belcony'    => 'Balcony',
                        'interior'   => 'Interior',
                        'royalsuite' => 'Royal Suite Class',
                    ];
                @endphp
                {{-- Image --}}
                <div class="row mb-3 m-auto">
                    <div class="col-md-6">
                        <strong>Image:</strong><br>
                        @if (!empty($data->image) && file_exists(public_path($data->image)))
                            <img src="{{ asset($data->image) }}" alt="Cabin Image" lt="Ship Image" width="650" height="350"
                                style="object-fit: cover;" class="rounded mt-2">
                        @else
                            <span>N/A</span>
                        @endif
                    </div>
                </div>

                {{-- Ship Name --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Ship Name:</strong> {{ $data->shipView->name ?? 'N/A' }}
                    </div>
                </div>

                {{-- Cabin Type --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cabin Type:</strong> {{ $cabinTypes[$data->cabin_type] ?? 'N/A' }}
                    </div>
                </div>

                {{-- Description --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Description:</strong> {{ $data->description ?? 'N/A' }}
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('shipCabin.index') }}" class="btn btn-primary">
                        <i data-feather="arrow-left"></i> Back
                    </a>
                </div>
                <br>
            </div>
        </div>
    </div>
@endsection
