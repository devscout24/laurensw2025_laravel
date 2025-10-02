@extends('backend.app')
@section('title', 'Edit Ship Cabin')

@push('style')
    <style>
        {{-- CKEditor CDN --}} .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <form action="{{ route('shipCabin.update', $data->id) }}" method="POST" enctype="multipart/form-data">
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

                        {{-- Cabin Type --}}
                        <div class="row mb-3">
                            <label class="col-3 col-form-label"><i>Cabin Type</i></label>
                            <div class="col-9">
                                <select name="cabin_type" class="form-control">
                                    <option value="">Select Cabin Type</option>
                                    <option value="oceanview"
                                        {{ old('cabin_type', $data->cabin_type) == 'oceanview' ? 'selected' : '' }}>Ocean
                                        View
                                    </option>
                                    <option value="balcony"
                                        {{ old('cabin_type', $data->cabin_type) == 'balcony' ? 'selected' : '' }}>Balcony
                                    </option>
                                    <option value="interior"
                                        {{ old('cabin_type', $data->cabin_type) == 'interior' ? 'selected' : '' }}>Interior
                                    </option>
                                    <option
                                        value="royalsuite"{{ old('cabin_type', $data->cabin_type) == 'royalsuite' ? 'selected' : '' }}>
                                        Royal Suite Class</option>
                                </select>
                                @error('cabin_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="row mb-3">
                            <label class="col-3 col-form-label"><i>Description</i></label>
                            <div class="col-9">
                                <textarea name="description" class="ck-editor form-control" placeholder="Cabin description...">{{ old('description', $data->description) }}</textarea>
                                @error('description')
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
@push('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('.ck-editor'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle',
                    'ImageToolbar', 'ImageUpload', 'MediaEmbed'
                ],
                height: '500px'
            })
            .catch(error => {
                console.error(error);
            });
        $(".single-select").select2({
            theme: "classic"
        });
        $(document).ajaxStart(function() {
            NProgress.start();
        });

        $(document).ajaxComplete(function() {
            NProgress.done();
        });
    </script>
@endpush
