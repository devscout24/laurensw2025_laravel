@extends('backend.app')

@section('title', 'Social Media page')

@push('style')
    <style>
        {{-- CKEditor CDN --}} .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@section('content')
    <main class="app-content content">
        <div class="card">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card-body">
                        <h3>Edit Form</h3>
                        <form action="{{ route('social.media.update', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="url" class="form-label">URL</label>
                                <input type="text" name="url" id="url" class="form-control"
                                    value="{{ old('url', $data->url) }}" placeholder="Enter url">
                                @error('url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control dropify" type="file" name="image"
                                    data-default-file="{{ asset($data->image) }}">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
@endpush
