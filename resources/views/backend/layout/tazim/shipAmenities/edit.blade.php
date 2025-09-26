@extends('backend.app')
@section('title', 'Edit Ship Cabin')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <form action="{{ route('shipAmenity.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Edit Cabin</h4>

                        {{-- Ship dropdown --}}
                        <div class="row mb-3">
                            <label class="col-3 col-form-label"><i>Ship</i></label>
                            <div class="col-9">
                                <select name="shipview_id" class="form-control">
                                    <option value="">Select Ship</option>
                                    @foreach ($ships as $ship)
                                        <option value="{{ $ship->id }}"
                                            {{ old('shipview_id', $data->shipview_id) == $ship->id ? 'selected' : '' }}>
                                            {{ $ship->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shipview_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Amenity --}}
                        <div class="row mb-3">
                            <label class="col-3 col-form-label"><i>Amenity</i></label>
                            <div class="col-9">
                                <input type="text" name="amenities" class="form-control" placeholder="Ship amenity..."
                                    value="{{ old('amenities', $data->amenities) }}">
                                @error('amenities')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="row mb-3">
                            <label class="col-3 col-form-label"><i>Image</i></label>
                            <div class="col-9">
                                <input type="file" name="image" class="form-control dropify"
                                    data-default-file="{{ $data->image ? asset($data->image) : '' }}">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('shipView.show', $data->shipview_id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
