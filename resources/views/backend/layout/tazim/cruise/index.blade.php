@extends('backend.app')

@section('title', 'Cruise List')

@section('content')
<div class="app-content content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Cruise List</h3>
            <a href="{{ route('cruise.import') }}" class="btn btn-success btn-sm">Import Cruises</a>
        </div>

        <div class="card-body">
            <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                <table class="table table-hover" id="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Ship</th>
                            <th>Destination</th>
                            <th>Embarcation</th>
                            <th>Disembarkation</th>
                            <th>Dates</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $trip)
                            <tr>
                                <td>{{ $trip->id ?? 'N/A' }}</td>
                                <td>{{ $trip->name ?? 'N/A' }}</td>
                                <td>{{ $trip->ship_name ?? 'N/A' }}</td>
                                <td>{{ $trip->destination ?? 'N/A' }}</td>
                                <td>{{ $trip->embarcation ?? 'N/A' }}</td>
                                <td>{{ $trip->disembarkation ?? 'N/A' }}</td>
                                <td>
                                    {{ $trip->start_date ?? 'N/A' }} - {{ $trip->end_date ?? 'N/A' }}
                                </td>
                                <td>
                                    <a href="{{ route('cruise.show', $trip->id) }}" class="btn btn-primary btn-sm">
                                        <i data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
