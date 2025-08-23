@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .dropify-wrapper {
            height: inherit !important;
        }
    </style>
@endpush
@section('title', 'Destination Covering Edit')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('destinationCover.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Edit <span id="Categorytitle">Destination Covering</span></h4>

                        {{-- <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Image</i></label>
                            <div class="col-9">
                                <input type="file" name="image" class="form-control" accept="image/*">

                                @if (!empty($data->image))
                                    <div class="mt-2">
                                        <img src="{{ asset($data->image) }}" alt="Image " width="60" height="60"
                                            class="rounded-circle" style="object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        </div> --}}

                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Image</i></label>
                            <div class="col-9">
                                <input class="form-control dropify" type="file" name="image"
                                    @isset($data->image)
                                                data-default-file="{{ asset($data->image) }}"
                                    @endisset>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Title</i></label>
                            <div class="col-9">
                                <input type="text" name="title" class="form-control" placeholder="Title..."
                                    value="{{ old('title', $data->title) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>URL</i></label>
                            <div class="col-9">
                                <input type="text" name="url" class="form-control" placeholder="url..."
                                    value="{{ old('url', $data->url) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary mt-2">
                                        <i class="ri-save-line"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

        <script>
            $('.dropify').dropify();
        </script>
    @endpush
@endsection
