@extends('backend.app')

@section('title', 'Trip Details')

@push('style')
<style>
    .trip-gallery-img {
        width: 100%;
        height: 200px; /* fixed height */
        object-fit: cover; /* crop/fit image */
        border-radius: 5px; /* optional, rounded corners */
    }
</style>
@endpush

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">
                <h3 class="mb-4">{{ $data->name ?? 'N/A' }}</h3>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Subtitle:</strong> {{ $data->subtitle ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Trip Code:</strong> {{ $data->trip_code ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Departure Date:</strong> {{ $data->departure_date ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Return Date:</strong> {{ $data->return_date ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12"><strong>Description:</strong> {!! $data->description ?? 'N/A' !!}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12"><strong>Highlights:</strong> {!! $data->highlights ?? 'N/A' !!}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Starting City:</strong> {{ $data->starting_city ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Finishing City:</strong> {{ $data->finishing_city ?? 'N/A' }}</div>
                </div>

                <hr>
                <h4>Ship Details</h4>
                @if ($data->ship)
                    <p><strong>Name:</strong> {{ $data->ship->name ?? 'N/A' }}</p>
                    <p><strong>Description:</strong> {!! $data->ship->description ?? 'N/A' !!}</p>
                    <p><strong>Last Known Position:</strong> {{ $data->ship->last_known_lat }},
                        {{ $data->ship->last_known_long }}</p>

                    <h5>Ship Specs</h5>
                    <ul>
                        @foreach ($data->ship->specs as $spec)
                            <li>{{ $spec->name }} : {{ $spec->value }}</li>
                        @endforeach
                    </ul>

                    <h5>Ship Gallery</h5>
                    <div class="row">
                        @foreach ($data->ship->gallery as $img)
                            <div class="col-md-3 mb-2">
                                <img src="{{ $img->image ?? '' }}" class="img-fluid" alt="Ship Image">
                            </div>
                        @endforeach
                    </div>
                @endif

                <hr>
                <h4>Cabins</h4>
                @foreach ($data->cabins as $cabin)
                    <div class="mb-3">
                        <h5>{{ $cabin->name }}</h5>
                        <p>{{ $cabin->description }}</p>
                        <p>Amount: {{ $cabin->amount }} {{ $cabin->currency }}</p>
                        <p>Deck Level: {{ $cabin->deck_level }}</p>

                        <h6>Prices:</h6>
                        <ul>
                            @foreach ($cabin->prices as $price)
                                <li>{{ $price->amount }} {{ $price->currency }}</li>
                            @endforeach
                        </ul>

                        @if ($cabin->image)
                            <img src="{{ $cabin->image ?? '' }}" class="img-fluid" alt="Cabin Image">
                        @endif
                    </div>
                @endforeach

                <hr>
                <h4>Itineraries</h4>
                <ul>
                    @foreach ($data->itineraries as $itinerary)
                        <li><strong>Day {{ $itinerary->day }} - {{ $itinerary->label }}:</strong> {!! $itinerary->body !!}
                        </li>
                    @endforeach
                </ul>

                <hr>
                <h4>Destinations</h4>
                <ul>
                    @foreach ($data->destinations as $dest)
                        <li>{{ $dest->name }}</li>
                    @endforeach
                </ul>

                <hr>
                <h4>Locations</h4>
                <ul>
                    @foreach ($data->locations as $loc)
                        <li>{{ $loc->name }}</li>
                    @endforeach
                </ul>

                <hr>
                <h4>Countries</h4>
                <ul>
                    @foreach ($data->countrries as $country)
                        <li>{{ $country->name }}</li>
                    @endforeach
                </ul>

                <hr>
                <h4>Trip Gallery</h4>
                <div class="row">
                    @foreach ($data->gallery as $img)
                        <div class="col-md-3 mb-2">
                            <img src="{{ $img->image ?? '' }}" class="img-fluid trip-gallery-img" alt="Trip Image">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
