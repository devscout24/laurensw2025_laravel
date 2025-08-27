@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .dropify-wrapper {
            height: inherit !important;
        }
    </style>
@endpush
@section('title', 'Create Home Tour')


@section('content')
<div class="app-content content">
    <div class="row">
        <!-- First Form (col-7) -->
        <div class="col-lg-7">
            <form action="{{ route('homeTour.store') }}" method="POST" enctype="multipart/form-data">@csrf
                <div class="card card-body">
                    <h4 class="mb-4">Home Tour <span id="Categorytitle">Create People Behind Trip</span></h4>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Label</i></label>
                        <div class="col-9">
                            <input type="text" name="label" class="form-control" placeholder="Label..."
                                value="{{ old('label') }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Trip Header</i></label>
                        <div class="col-9">
                            <input type="text" name="header" class="form-control" placeholder="Header..."
                                value="{{ old('header') }}">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Trip Title</i></label>
                        <div class="col-9">
                            <input type="text" name="title" class="form-control" placeholder="Title..."
                                value="{{ old('title') }}">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Duration</i></label>
                        <div class="col-9">
                            <input type="text" name="duration" class="form-control" placeholder="Duration..."
                                value="{{ old('duration') }}">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Ship</i></label>
                        <div class="col-9">
                            <input type="text" name="ship" class="form-control" placeholder="Ship..."
                                value="{{ old('ship') }}">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Price</i></label>
                        <div class="col-9">
                            <input type="number" name="price" class="form-control" placeholder="Price..."
                                value="{{ old('price') }}" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Image</i></label>
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

                    <div class="text-end">
                        <button type="submit" class="btn btn-success mt-2">
                            <i class="ri-save-line"></i> submit
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Second Form (col-5) -->
        <div class="col-lg-5">
            <form action="{{ route('popularNatureTourheader.store') }}" method="POST" enctype="multipart/form-data">@csrf
                <div class="card card-body">
                    <h4 class="mb-4"><span id="Categorytitle">Create Header & Title</span></h4>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Header</i></label>
                        <div class="col-9">
                            <input type="text" name="header" class="form-control" placeholder="Header..."
                                value="{{ $natureData->header ?? '' }}">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-3 col-form-label"><i>Title</i></label>
                        <div class="col-9">
                            <input type="text" name="title" class="form-control" placeholder="Title..."
                                value="{{ $natureData->title ?? '' }}">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success mt-2">
                            <i class="ri-save-line"></i> submit
                        </button>
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
