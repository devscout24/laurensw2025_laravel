@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .dropify-wrapper {
            height: inherit !important;
        }
    </style>
@endpush
@section('title', 'Edit Travel Advisor')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('travelAdvisor.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Edit <span id="Categorytitle">Travel Advisor</span></h4>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Name</i></label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" placeholder="name..."
                                    value="{{ old('name', $data->name) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Designation</i></label>
                            <div class="col-9">
                                <input type="text" name="designation" class="form-control" placeholder="designation..."
                                    value="{{ old('designation', $data->designation) }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Experience</i></label>
                            <div class="col-9">
                                <input type="number" name="experience" class="form-control" placeholder="experience..."
                                    value="{{ old('experience', $data->experience) }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Successful Trip</i></label>
                            <div class="col-9">
                                <input type="number" name="trip_success" class="form-control" placeholder="trip_success..."
                                    value="{{ old('trip_success', $data->trip_success) }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Whatsapp</i></label>
                            <div class="col-9">
                                <input type="number" name="whatsapp" class="form-control" placeholder="whatsapp..."
                                    value="{{ old('whatsapp', $data->whatsapp) }}">
                            </div>
                        </div>

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
