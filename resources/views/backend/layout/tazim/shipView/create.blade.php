@extends('backend.app')

@section('title', 'Ship Create')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <form action="{{ route('shipView.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-body">
                        <h4 class="mb-4"><span id="Categorytitle">Create Ship</span></h4>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Name</i></label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" placeholder="Ship Name..."
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Description</i></label>
                            <div class="col-9">
                                <textarea name="description" class="form-control" placeholder="Description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Build Year</i></label>
                            <div class="col-9">
                                <input type="number" name="build_year" class="form-control" placeholder="e.g. 2020"
                                    value="{{ old('build_year') }}">
                                @error('build_year')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Crew Number</i></label>
                            <div class="col-9">
                                <input type="number" name="crew_number" class="form-control"
                                    placeholder="Number of crew..." value="{{ old('crew_number') }}">
                                @error('crew_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Max Guest</i></label>
                            <div class="col-9">
                                <input type="number" name="max_guests" class="form-control" placeholder="Max guests..."
                                    value="{{ old('max_guests') }}">
                                @error('max_guests')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Length</i></label>
                            <div class="col-9">
                                <input type="number" name="length" class="form-control" placeholder="Length (unit-meter)..."
                                    value="{{ old('length') }}">
                                @error('length')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Zodiac Boats</i></label>
                            <div class="col-9">
                                <input type="text" name="zodiac_boats" class="form-control"
                                    placeholder="Zodiac Boats..." value="{{ old('zodiac_boats') }}">
                                @error('zodiac_boats')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Capacity</i></label>
                            <div class="col-9">
                                <input type="number" name="capacity" class="form-control" placeholder="Capacity..."
                                    value="{{ old('capacity') }}">
                                @error('capacity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Comfort Level</i></label>
                            <div class="col-9">
                                <select name="comfort_level" class="form-control">
                                    <option value="">Select Comfort Level</option>
                                    {{-- <option value="Basic" {{ old('comfort_level') == 'Basic' ? 'selected' : '' }}>Basic
                                    </option> --}}
                                    <option value="standard" {{ old('comfort_level') == 'standard' ? 'selected' : '' }}>
                                        Standard</option>
                                    <option value="premium" {{ old('comfort_level') == 'premium' ? 'selected' : '' }}>
                                        Premium</option>
                                    <option value="luxury" {{ old('comfort_level') == 'luxury' ? 'selected' : '' }}>Luxury
                                    </option>
                                </select>
                                @error('comfort_level')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Price</i></label>
                            <div class="col-9">
                                <input type="number" step="0.01" min="0" name="price" class="form-control" placeholder="Price..."
                                    value="{{ old('price') }}">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Image</i></label>
                            <div class="col-9">
                                <input class="form-control dropify" type="file" name="image">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
@endsection
