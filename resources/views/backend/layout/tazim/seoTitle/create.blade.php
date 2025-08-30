@extends('backend.app')
@section('title', 'SEO Title Create')

@section('content')
    <div class="app-content content">
        <div class="row">
            @if ($data->count() < 3)
                <div class="col-lg-6 m-auto">
                    <form action="{{ route('seoTitle.store') }}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="card card-body">
                            <h4 class="mb-4">User <span id="Categorytitle">SEO Title Create</span></h4>

                            <div class="row mb-2">
                                <label class="col-3 col-form-label"><i>Title</i></label>
                                <div class="col-9">
                                    <input type="text" name="title" class="form-control" placeholder="Title..."
                                        value="{{ old('title') }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-3 col-form-label"><i>Description</i></label>
                                <div class="col-9">
                                    {{-- <input type="text" name="description" class="form-control" placeholder="Description..."
                                    value="{{ old('description') }}"> --}}
                                    <textarea ntype="text" name="description" class="form-control" placeholder="Description..."
                                        value="{{ old('description') }}" cols="30" rows="20"></textarea>
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
            @endif
        </div>
    </div>
@endsection
