@extends('backend.app')
@section('title', 'Deck Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Deck Details</h3>
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

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('shipDeck.index') }}" class="btn btn-primary">
                        <i data-feather="arrow-left"></i> Back
                    </a>
                </div>
                <br>
            </div>
        </div>
    </div>
@endsection
