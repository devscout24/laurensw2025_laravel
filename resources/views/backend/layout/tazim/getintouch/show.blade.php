@extends('backend.app')
@section('title', 'Customer Message Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Inbox Message Details</h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $data->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Email:</strong> {{ $data->email ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Phone:</strong> {{ $data->phone ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Subject:</strong> {{ $data->subject ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Message:</strong> {{ $data->message ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
