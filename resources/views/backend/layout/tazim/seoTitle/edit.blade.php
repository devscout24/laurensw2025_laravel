@extends('backend.app')
@push('style')
    <style>
        {{-- CKEditor CDN --}} .ck-editor__editable_inline {
            min-height: 100 px;
        }
    </style>
@endpush
@section('title', 'SEO Title Edit')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('seoTitle.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Edit SEO Title</h4>

                        {{-- Title --}}
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Title</i></label>
                            <div class="col-9">
                                <input type="text" name="title" class="form-control" placeholder="Title..."
                                    value="{{ old('title', $data->title) }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Description</i></label>
                            <div class="col-9">
                                <textarea name="description" class="ck-editor form-control" placeholder="Description..." cols="30" rows="6">{{ old('description', $data->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Language --}}
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Language</i></label>
                            <div class="col-9">
                                <select name="lang_id" class="form-control">
                                    <option value="">Select Language</option>
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->id }}"
                                            {{ old('lang_id', $data->lang_id) == $lang->id ? 'selected' : '' }}>
                                            {{ $lang->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lang_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary mt-2">
                                    <i class="ri-save-line"></i> Update
                                </button>
                            </div>
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
