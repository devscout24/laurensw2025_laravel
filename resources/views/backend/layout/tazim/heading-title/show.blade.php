@extends('backend.app')
@section('title', 'Heading & Title Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Heading & Title Details</h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Header:</strong> {{ $data->heading ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Title Description:</strong> {{ $data->title ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
