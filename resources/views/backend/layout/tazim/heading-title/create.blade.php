@extends('backend.app')
@section('title', 'Heading & Title Create')

@section('content')
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('headingTitle.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-body">
                        <h4 class="mb-4">User <span id="Categorytitle">Heading & Title Create</span></h4>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Header</i></label>
                            <div class="col-9">
                                <input type="text" name="heading" class="form-control" placeholder="Heading..."
                                    value="{{ old('heading') }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Title Description</i></label>
                            <div class="col-9">
                                <input type="text" name="title" class="form-control" placeholder="Title..."
                                    value="{{ old('title') }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Other Description</i></label>
                            <div class="col-9">
                                <textarea type="text" name="description" class="form-control" placeholder="description..."
                                    value="{{ old('description') }}" cols="30" rows="10"></textarea>
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
