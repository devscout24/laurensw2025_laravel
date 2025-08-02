@extends('backend.app')
@section('title', 'Create Mission')


@section('content')
    <div class="app-content content ">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('mission.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Mission <span id="Categorytitle">Create</span></h4>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Header</i></label>
                            <div class="col-9">
                                <input type="text" name="header" class="form-control" placeholder="Header..."
                                    autocomplete="off" value="{{ $data->header ?? '' }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Title</i></label>
                            <div class="col-9">
                                <input type="text" name="title" class="form-control" placeholder="Title..."
                                    autocomplete="off" value="{{ $data->title ?? '' }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Description</i></label>
                            <div class="col-9">
                                <input type="text" name="description" class="form-control" placeholder="description..."
                                    autocomplete="off" value="{{ $data->description ?? '' }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Image 1</i></label>
                            <div class="col-9">
                                {{-- <input type="file" name="image_1" class="form-control" placeholder="Image..."
                                autocomplete="off" value="{{ $data->image_1 ?? '' }}"> --}}
                                <input type="file" name="image_1" class="form-control" accept="image/*">

                                @if (!empty($data->image_1))
                                    <div class="mt-2">
                                        <img src="{{ asset($data->image_1) }}" alt="Image 1" width="60" height="60"
                                            class="rounded-circle" style="object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>Image 2</i></label>
                            <div class="col-9">
                                {{-- <input type="file" name="image_2" class="form-control" placeholder="Image..."
                                autocomplete="off" value="{{ $data->image_2 ?? '' }}"> --}}
                                <input type="file" name="image_2" class="form-control" accept="image/*">

                                @if (!empty($data->image_2))
                                    <div class="mt-2">
                                        <img src="{{ asset($data->image_2) }}" alt="Image 2" width="60" height="60"
                                            class="rounded-circle" style="object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success mt-2">
                                        <i class="ri-save-line"></i> Submit
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
