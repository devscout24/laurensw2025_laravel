@extends('backend.app')

@section('title', 'Trips List')

@section('content')
    <div class="app-content content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trips List</h3>
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('trips.import') }}" class="btn btn-success btn-sm mr-2">Import Trips</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Trip Name</th>
                                <th>Ship Name</th>
                                <th>Destinations</th>
                                <th>Cabins Count</th>
                                <th>Gallery Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $trip)
                                <tr>
                                    <td>{{ $trip->id }}</td>
                                    <td>{{ $trip->name ?? 'N/A' }}</td>
                                    <td>{{ $trip->ship->name ?? 'N/A' }}</td>
                                    <td>
                                        @foreach ($trip->destinations as $dest)
                                            {{ $dest->name }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $trip->cabins->count() }}</td>
                                    <td>{{ $trip->gallery->count() }}</td>
                                    <td>
                                        <a href="{{ route('trips.show', $trip->id) }}"
                                            class="btn btn-primary btn-sm">
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
