@extends('backend.app')

@section('title', 'Create Social Media')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .dropify-wrapper {
            height: inherit !important;
        }
    </style>
@endpush

@section('content')
    <div class="app-content content">
        <div class="card">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card box-shadow-0">
                        <div class="card-body">
                            <h3>Create Form</h3>
                            <form action="{{ route('social.media.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="url" class="form-label">url</label>
                                    <input type="text" name="url" id="url" class="form-control"
                                        value="{{ old('url') }}" placeholder="Enter url">
                                    @error('url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control dropify" type="file" name="image"
                                        @isset($data->image)
                                                data-default-file="{{ asset($data->image) }}"
                                    @endisset>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script>
        $('.dropify').dropify();
    </script>
@endpush
