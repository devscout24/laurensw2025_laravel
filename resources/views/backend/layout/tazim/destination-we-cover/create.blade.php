@extends('backend.app')
@section('title', 'Destination Covering Create')

@section('content')
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('destinationCover.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-body">
                        <h4 class="mb-4">User <span id="Categorytitle">Destination Covering Create</span></h4>

                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Image</i></label>
                            <div class="col-9">
                                <input type="file" name="image" class="form-control" accept="image/*">

                                @if (!empty($data->image))
                                    <div class="mt-2">
                                        <img src="{{ asset($data->image) }}" alt="Image " width="60" height="60"
                                            class="rounded-circle" style="object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Title</i></label>
                            <div class="col-9">
                                <input type="text" name="title" class="form-control" placeholder="Title..."
                                    value="{{ old('title') }}">
                            </div>
                        </div>

                        

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>URL</i></label>
                            <div class="col-9">
                                <input type="text" name="url" class="form-control" placeholder="url..."
                                    value="{{ old('url') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success mt-2">
                                        <i class="ri-save-line"></i> Create
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Include Star Rating JS --}}
    <script src="{{ asset('js/star-rating.js') }}"></script>
    <script>
        // If using a plugin like StarRating.js that targets select
        const stars = new StarRating('.star-rating');
    </script>
@endsection
