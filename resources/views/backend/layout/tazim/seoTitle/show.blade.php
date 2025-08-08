@extends('backend.app')
@section('title', 'SEO Title Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">SEO Title Details</h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Title:</strong> {{ $data->title ?? 'N/A' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Description:</strong> {{ $data->description ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
