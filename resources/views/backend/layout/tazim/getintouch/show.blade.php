@extends('backend.app')
@section('title', 'Customer Message Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">Get In Touch Details</h3>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Name:</strong></div>
                    <div class="col-md-9">{{ $data->name ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9">{{ $data->email ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Phone:</strong></div>
                    <div class="col-md-9">{{ $data->phone ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Subject:</strong></div>
                    <div class="col-md-9">{{ $data->subject ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Message:</strong></div>
                    <div class="col-md-9">{!! nl2br(e($data->message ?? 'N/A')) !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
