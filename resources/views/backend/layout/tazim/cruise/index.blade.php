@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/datatable/css/datatables.min.css') }}">
@endpush
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
                                {{-- <th>ID</th> --}}
                                <th>Name</th>
                                <th>Ship</th>
                                <th>Destination</th>
                                <th>Embarcation</th>
                                <th>Disembarkation</th>
                                <th>Dates</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="{{ asset('backend/assets/datatable/js/datatables.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                });
                $(document).ready(function() {
                    if (!$.fn.DataTable.isDataTable('#data-table')) {
                        $('#data-table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('cruise.getData') }}",
                            columns: [{
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'ship_name',
                                    name: 'ship_name'
                                },
                                {
                                    data: 'destination',
                                    name: 'destination'
                                },
                                {
                                    data: 'embarcation',
                                    name: 'embarcation'
                                },
                                {
                                    data: 'disembarkation',
                                    name: 'disembarkation'
                                },
                                {
                                    data: 'trip_dates',
                                    name: 'trip_dates'
                                },
                                {
                                    data: 'action',
                                    name: 'action'
                                }
                            ]
                        });
                    }
                });

            });
        </script>
    @endpush
@endsection
