@extends('backend.app')

@section('title', 'Create Meta Tag & Title')

@section('content')
    <div class="app-content content">
        <div class="row justify-content-center">
            @foreach ($languages as $lang)
                @php
                    $meta = $metaTags[$lang->id] ?? null;
                @endphp
                <div class="col-lg-6 mb-3">
                    <form action="{{ route('naturePageMetaTag.store') }}" method="POST">@csrf
                        <div class="card card-body">
                            <h4 class="mb-4">Trips Page Meta Tag - {{ $lang->name }}</h4>

                            <input type="hidden" name="lang_id" value="{{ $lang->id }}">

                            <div class="row mb-2">
                                <label class="col-3 col-form-label"><i>Title</i></label>
                                <div class="col-9">
                                    <input type="text" name="title" class="form-control" placeholder="Title..."
                                        value="{{ old('title', $meta->title ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-3 col-form-label"><i>Description</i></label>
                                <div class="col-9">
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Description..."
                                        value="{{ old('description', $meta->description ?? '') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-success mt-2">
                                        <i class="ri-save-line"></i> Save / Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
