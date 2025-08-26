@extends('backend.app')

@section('title', 'Trip Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">

                <h2>{{ $trip->name }}</h2>
                <p><strong>Region:</strong> {{ $trip->region ?? 'N/A' }}</p>
                <p><strong>Ship Name:</strong> {{ $trip->ship_name ?? 'N/A' }}</p>
                <p><strong>Departure:</strong> {{ $trip->departure_date ?? 'N/A' }}</p>
                <p><strong>Return:</strong> {{ $trip->return_date ?? 'N/A'}}</p>
                <p><strong>Summary:</strong> {!! $trip->summary ?? 'N/A' !!}</p>

                {{-- Photos --}}
                <h4>Photos</h4>
                <div class="row">
                    @foreach ($trip->photos as $photo)
                        <div class="col-md-3 mb-3">
                            <img src="{{ $photo->url ?? 'N/A'}}" class="img-fluid rounded" alt="Trip Photo">
                        </div>
                    @endforeach
                </div>

                {{-- Cabins --}}
                <h4>Cabins</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Old Price</th>
                            <th>Discount</th>
                            <th>Units</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trip->cabinsTwos as $cabin)
                            <tr>
                                <td>{{ $cabin->title ?? 'N/A'}}</td>
                                <td>{{ $cabin->price ?? 'N/A'}}</td>
                                <td>{{ $cabin->old_price ?? 'N/A'}}</td>
                                <td>{{ $cabin->discount ?? 0 }}</td>
                                <td>{{ $cabin->cab_units ?? 'N/A'}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Extras --}}
                <h4>Extras</h4>
                <ul>
                    @foreach ($trip->extras as $extra)
                        <li>{{ $extra->name ?? 'N/A'}} - {{ $extra->price ?? 'N/A'}} ({{ $extra->availability ?? 'N/A'}})</li>
                    @endforeach
                </ul>

                {{-- Destinations --}}
                <h4>Destinations</h4>
                <ul>
                    @foreach ($trip->destinationsTwos as $destination)
                        <li>{{ $destination->name ?? 'N/A'}}</li>
                    @endforeach
                </ul>

                {{-- Itineraries --}}
                <h4>Itinerary</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Title</th>
                            <th>Port</th>
                            <th>Location</th>
                            <th>Summary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trip->itinerariesTwos as $itinerary)
                            <tr>
                                <td>{{ $itinerary->day ?? 'N/A'}}</td>
                                <td>{{ $itinerary->title ?? 'N/A'}}</td>
                                <td>{{ $itinerary->port ?? 'N/A'}}</td>
                                <td>{{ $itinerary->location ?? 'N/A'}}</td>
                                <td>{!! $itinerary->summary ?? 'N/A' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
