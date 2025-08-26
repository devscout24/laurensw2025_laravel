@extends('backend.app')

@section('title', 'Trips List Two')

@section('content')
    <div class="app-content content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trips List Two</h3>
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('trips.two.import') }}" class="btn btn-success btn-sm mr-2">Import Trips Two</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Region</th>
                                <th>Code</th>
                                <th>Combination</th>
                                <th>Only in Combination</th>
                                <th>Departure</th>
                                <th>Return</th>
                                <th>Trip Name</th>
                                <th>Embark</th>
                                <th>Disembark</th>
                                <th>Days</th>
                                <th>Nights</th>
                                <th>Ship Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $trip)
                                <tr>
                                    <td>{{ $trip->id }}</td>
                                    <td>{{ $trip->region ?? 'N/A' }}</td>
                                    <td>{{ $trip->code ?? 'N/A' }}</td>
                                    <td>{{ $trip->combination ? 'Yes' : 'No' }}</td>
                                    <td>{{ $trip->only_in_combination ? 'Yes' : 'No' }}</td>
                                    <td>{{ $trip->departure_date ?? 'N/A' }}</td>
                                    <td>{{ $trip->return_date ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($trip->name ?? 'N/A', 50) }}</td>
                                    <td>{{ $trip->embark ?? 'N/A' }}</td>
                                    <td>{{ $trip->disembark ?? 'N/A' }}</td>
                                    <td>{{ $trip->days ?? 'N/A' }}</td>
                                    <td>{{ $trip->nights ?? 'N/A' }}</td>
                                    <td>{{ $trip->ship_name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('trips.two.show', $trip->id) }}" class="btn btn-primary btn-sm">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
