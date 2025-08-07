@extends('backend.app')
@section('title', 'Rating Edit')

@section('content')
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('rating.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Edit <span id="Categorytitle">User Rating</span></h4>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Name</i></label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" placeholder="Name..."
                                    value="{{ old('name', $data->name) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Designation</i></label>
                            <div class="col-9">
                                <input type="text" name="designation" class="form-control" placeholder="Designation..."
                                    value="{{ old('designation', $data->designation) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Description</i></label>
                            <div class="col-9">
                                <input type="text" name="description" class="form-control" placeholder="Description..."
                                    value="{{ old('description', $data->description) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Image</i></label>
                            <div class="col-9">
                                <input type="file" name="image" class="form-control" accept="image/*">
                                @if (!empty($data->image))
                                    <div class="mt-2">
                                        <img src="{{ asset($data->image) }}" alt="Image" width="60" height="60"
                                            class="rounded-circle" style="object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Rating</i></label>
                            <div class="col-9">
                                <select name="rating" class="star-rating form-control">
                                    <option value="">Select a rating</option>
                                    <option value="5" {{ old('rating', $data->rating) == 5 ? 'selected' : '' }}>
                                        Excellent</option>
                                    <option value="4" {{ old('rating', $data->rating) == 4 ? 'selected' : '' }}>Very
                                        Good</option>
                                    <option value="3" {{ old('rating', $data->rating) == 3 ? 'selected' : '' }}>Average
                                    </option>
                                    <option value="2" {{ old('rating', $data->rating) == 2 ? 'selected' : '' }}>Poor
                                    </option>
                                    <option value="1" {{ old('rating', $data->rating) == 1 ? 'selected' : '' }}>
                                        Terrible</option>
                                </select>
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

    {{-- Include Star Rating JS --}}
    <script src="{{ asset('js/star-rating.js') }}"></script>
    <script>
        const stars = new StarRating('.star-rating');
    </script>
@endsection
