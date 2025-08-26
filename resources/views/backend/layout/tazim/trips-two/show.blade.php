@extends('backend.app')

@section('title', 'Trip Details')

@section('content')
    <div class="app-content content">
        <div class="container mt-5">
            <div class="card card-body">

                <h2>{{ $trip->name }}</h2> <hr>
                <p><strong>Region:</strong> {{ $trip->region ?? 'N/A' }}</p>
                <p><strong>External ID:</strong> {{ $trip->external_id ?? 'N/A' }}</p>
                <p><strong>Code:</strong> {{ $trip->code ?? 'N/A' }}</p>
                <p><strong>Combination:</strong> {{ $trip->combination ? 'Yes' : 'No' }}</p>
                <p><strong>Only in Combination:</strong> {{ $trip->only_in_combination ? 'Yes' : 'No' }}</p>
                <p><strong>Translated:</strong> {{ $trip->translated ? 'Yes' : 'No' }}</p>
                <p><strong>Departure Date:</strong> {{ $trip->departure_date ?? 'N/A' }}</p>
                <p><strong>Return Date:</strong> {{ $trip->return_date ?? 'N/A' }}</p>
                <p><strong>Summary:</strong> {!! $trip->summary ?? 'N/A' !!}</p>
                <p><strong>Embark:</strong> {{ $trip->embark ?? 'N/A' }}</p>
                <p><strong>Disembark:</strong> {{ $trip->disembark ?? 'N/A' }}</p>
                <p><strong>Dr Usp:</strong> {!! $trip->dr_usp ?? 'N/A' !!}</p>
                <p><strong>Trip Included:</strong> {!! $trip->trip_included ?? 'N/A' !!}</p>
                <p><strong>Trip Excluded:</strong> {!! $trip->trip_excluded ?? 'N/A' !!}</p>
                <p><strong>Days:</strong> {{ $trip->days ?? 'N/A' }}</p>
                <p><strong>Nights:</strong> {{ $trip->nights ?? 'N/A' }}</p>
                <p><strong>Ship ID:</strong> {{ $trip->ship_id ?? 'N/A' }}</p>
                <p><strong>Ship Name:</strong> {{ $trip->ship_name ?? 'N/A' }}</p>
                <p><strong>Map:</strong>
                    <img src="{{ $trip->map ?? 'N/A' }}" class="img-fluid rounded" alt="Trip map">
                </p>

                {{-- Photos --}}
                <h4>Photos</h4>
                <div class="row">
                    @foreach ($trip->photos as $photo)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{ $photo->url ?? 'N/A' }}" class="card-img-top" alt="Trip Photo">
                            </div>
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
                                <td>{{ $cabin->title ?? 'N/A' }}</td>
                                <td>{{ $cabin->price ?? 'N/A' }}</td>
                                <td>{{ $cabin->old_price ?? 'N/A' }}</td>
                                <td>{{ $cabin->discount ?? 0 }}</td>
                                <td>{{ $cabin->cab_units ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Extras --}}
                <h4>Extras</h4>
                <ul>
                    @foreach ($trip->extras as $extra)
                        <li>{{ $extra->name ?? 'N/A' }} - {{ $extra->price ?? 'N/A' }}
                            ({{ $extra->availability ?? 'N/A' }})</li>
                    @endforeach
                </ul>

                {{-- Destinations --}}
                <h4>Destinations</h4>
                <ul>
                    @foreach ($trip->destinationsTwos as $destination)
                        <li>{{ $destination->name ?? 'N/A' }}</li>
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
                                <td>{{ $itinerary->day ?? 'N/A' }}</td>
                                <td>{{ $itinerary->title ?? 'N/A' }}</td>
                                <td>{{ $itinerary->port ?? 'N/A' }}</td>
                                <td>{{ $itinerary->location ?? 'N/A' }}</td>
                                <td>{!! $itinerary->summary ?? 'N/A' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('trips.two.list') }}" class="btn btn-primary"><i data-feather="arrow-left"></i>
                        Back</a>
                </div>
                <br>
            </div>
        </div>
    </div>
@endsection
