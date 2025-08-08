@extends('backend.app')
@section('title', 'Heading & Title Edit')

@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('headingTitle.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Edit <span id="Categorytitle">Heading & Title</span></h4>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Header</i></label>
                            <div class="col-9">
                                <input type="text" name="heading" class="form-control" placeholder="Heading..."
                                    value="{{ old('heading', $data->heading) }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-3 col-form-label"><i>Title Description</i></label>
                            <div class="col-9">
                                <input type="text" name="title" class="form-control" placeholder="Title..."
                                    value="{{ old('title', $data->title) }}">
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
