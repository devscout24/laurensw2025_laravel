@extends('backend.app')

@section('title', 'Update Tanslation Api')

@section('content')
    <div class="app-content content ">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <form action="{{ route('translateApi.update') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-body">
                        <h4 class="mb-4">Update<span id="Categorytitle">Tanslation Api</span></h4>
                        <div class="row mb-2">
                            <label for="" class="col-3 col-form-label"><i>API</i></label>
                            <div class="col-9">
                                <input type="text" class="form-control @error('api_key') is-invalid @enderror"
                                    placeholder="API KEY" name="api_key" value="{{ env('GOOGLE_TRANSLATE_KEY') }}" required>
                                @error('api_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
