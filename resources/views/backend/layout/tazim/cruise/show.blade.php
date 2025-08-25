@extends('backend.app')

@section('title', 'Cruise Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">

                {{-- Cruise main info --}}
                <h3>{{ $data->name }}</h3>
                <p><strong>Length:</strong> {{ $data->length }} days</p>
                <p><strong>Ship Name:</strong> {{ $data->ship_name }}</p>
                <p><strong>Destination:</strong> {{ $data->destination }}</p>
                <p><strong>Embarcation:</strong> {{ $data->embarcation }}</p>
                <p><strong>Disembarkation:</strong> {{ $data->disembarkation }}</p>
                <p><strong>Start Date:</strong> {{ $data->start_date }}</p>
                <p><strong>End Date:</strong> {{ $data->end_date }}</p>
                <hr>

                {{-- Cruise Days --}}
                <h4>Days</h4>
                 @foreach ($data->days as $day)
                    <div class="mb-3">
                        <h5>Day {{ $loop->iteration }}: {{ $day->title }}</h5>
                        <div class="day-text">
                            {!! $day->text ?? '' !!}
                        </div>

                        <div class="row">
                            @foreach ($day->images as $img)
                                <div class="col-md-3 mb-3">
                                    <div class="card shadow-sm">
                                        <img src="{{ $img->image_url ?? asset('frontend/no-image.jpg') }}" class="card-img-top img-fluid rounded"
                                            alt="Day Image" style="height: 180px; object-fit: cover;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach


               {{--  @foreach ($data->days as $day)
                    <div class="mb-3">
                        <h5>Day {{ $loop->iteration }}: {{ $day->title }}</h5>
                        <div class="day-text">
                            {!! $day->text ?? '' !!}
                        </div>

                        <div class="row">
                            @foreach ($day->images as $img)
                                <div class="col-md-3 mb-2">
                                    <div class="card shadow-sm">
                                        <img src="{{ route('image.proxy', ['url' => $img->image_url]) }}"
                                            onerror="this.onerror=null;this.src='{{ asset('frontend/no-image.jpg') }}';"
                                            alt="Day Image" class="card-img-top img-fluid rounded"
                                            style="height:180px; object-fit:cover;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach --}}
                <hr>

                {{-- Cabins --}}
                <h4>Cabins</h4>
                <ul>
                    @foreach ($data->cabins as $cabin)
                        <li>{{ $cabin->name ?? 'N/A' }} - Price: {{ $cabin->price ?? 'N/A' }}</li>
                    @endforeach
                </ul>

                <hr>

                {{-- Highlights --}}
                <h4>Highlights</h4>
                <ul>
                    @foreach ($data->highlights as $highlight)
                        <li>{{ $highlight->text ?? 'N/A' }}</li>
                    @endforeach
                </ul>

                <hr>

                {{-- Notes --}}
                <h4>Notes</h4>
                <ul>
                    @foreach ($data->notes as $note)
                        <li>{{ $note->text ?? 'N/A' }}</li>
                    @endforeach
                </ul>

                <hr>

                {{-- Offers --}}
                <h4>Offers</h4>
                <ul>
                    @foreach ($data->offers as $offer)
                        <li>{{ $offer->text ?? 'N/A' }}</li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
@endsection
