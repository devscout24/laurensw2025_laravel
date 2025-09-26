@extends('backend.app')

@push('style')
    <style>
        .dynamic-page-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 20px auto;
        }

        .dynamic-page-card img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .dynamic-page-card h4 {
            margin-top: 10px;
            color: #062472;
            /* Softvence Blue */
        }

        .dynamic-page-card .badge {
            font-size: 14px;
            padding: 5px 10px;
        }

        .dynamic-page-card .field-label {
            font-weight: 600;
            color: #333;
        }

        .dynamic-page-card .field-value {
            color: #555;
            margin-bottom: 15px;
        }
    </style>
@endpush

@section('title', 'Dynamic Page Details')

@section('content')
    <div class="app-content content">


        <div class="field">
            <h4 class="field-label">Status:</h4>
            <div class="field-value">
                @if ($data->status === 'active')
                    <span class="badge badge-success">Active</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif
            </div>
        </div>

        <div class="field">
            <h4 class="field-label">Snippet Title:</h4>
            <div class="field-value">
                <h1> {{ $data->title ?? 'N/A' }} </h1>
            </div>
        </div>

        <div class="field">
            <h4 class="field-label">Snippet Code:</h4>
             <h5> {{ $data->snippet_content ?? 'N/A' }} </h5>
        </div>

        <div class="mt-3">
            <a href="{{ route('snippet.index') }}" class="btn btn-success">Back to List</a>
        </div>
    </div>
@endsection
@push('script')
@endpush
