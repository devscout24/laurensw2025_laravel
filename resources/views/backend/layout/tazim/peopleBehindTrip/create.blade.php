@extends('backend.app')
@section('title', 'Create User')


@section('content')
    <div class="app-content content ">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('peopleBehind.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-body">
                        <h4 class="mb-4">User <span id="Categorytitle">Create People Behind Trip</span></h4>

                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Name</i></label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" placeholder="Name..." value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Designation</i></label>
                            <div class="col-9">
                                <input type="text" name="designation" class="form-control" placeholder="designation..." value="{{ old('designation') }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Description</i></label>
                            <div class="col-9">
                                <input type="text" name="description" class="form-control" placeholder="description..." value="{{ old('description') }}">
                            </div>
                        </div>
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
