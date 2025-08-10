@extends('backend.app')
@section('title', 'Premium Services & Inclusives Edit')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('whyTravelWithUs.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Edit <span id="Categorytitle">Premium Services & Inclusives</span></h4>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Header</i></label>
                            <div class="col-9">
                                <input type="text" name="header" class="form-control" placeholder="Header..."
                                    value="{{ old('header', $data->header) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Title</i></label>
                            <div class="col-9">
                                <input type="text" name="title" class="form-control" placeholder="Title..."
                                    value="{{ old('title', $data->title) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Description 1</i></label>
                            <div class="col-9">
                                <input type="text" name="description1" class="form-control" placeholder="description..."
                                    value="{{ old('description1', $data->description1) }}" cols="30" rows="10">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Description 2</i></label>
                            <div class="col-9">
                                <input type="text" name="description2" class="form-control" placeholder="description..."
                                    value="{{ old('description2', $data->description2) }}" cols="30" rows="10">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Description 3</i></label>
                            <div class="col-9">
                                <input type="text" name="description3" class="form-control" placeholder="description..."
                                    value="{{ old('description3', $data->description3) }}" cols="30" rows="10">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Description 4</i></label>
                            <div class="col-9">
                                <input type="text" name="description4" class="form-control" placeholder="description..."
                                    value="{{ old('description4', $data->description4) }}" cols="30" rows="10">
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
@endsection
