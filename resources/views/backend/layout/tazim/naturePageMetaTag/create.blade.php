@extends('backend.app')

@section('title', 'Create Meta Tag & Title')

@section('content')
    <div class="app-content content ">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('naturePageMetaTag.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Create <span id="Categorytitle">Home Page Meta Tag & Title</span></h4>
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
                                <input type="text" name="description" class="form-control" placeholder="Description..."
                                    autocomplete="off" value="{{ $data->description ?? '' }}">
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