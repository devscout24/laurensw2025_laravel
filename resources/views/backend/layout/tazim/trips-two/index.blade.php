@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/datatable/css/datatables.min.css') }}">
@endpush
@section('title', 'Trips List Two')

@section('content')
    <div class="app-content content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trips List Two</h3>
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('booking-two.index') }}" class="btn btn-primary btn-sm mr-2">Booking Lists</a>
                    <a href="{{ route('trips.two.import') }}" class="btn btn-success btn-sm mr-2">Import Trips Two</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
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
                            ajax: "{{ route('trips.two.getData') }}",
                            columns: [{
                                    data: 'region',
                                    name: 'region'
                                },
                                {
                                    data: 'code',
                                    name: 'code'
                                },
                                {
                                    data: 'combination',
                                    name: 'combination'
                                },
                                {
                                    data: 'only_in_combination',
                                    name: 'only_in_combination'
                                },
                                {
                                    data: 'departure_date',
                                    name: 'departure_date'
                                },
                                {
                                    data: 'return_date',
                                    name: 'return_date'
                                },
                                {
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'embark',
                                    name: 'embark'
                                },
                                {
                                    data: 'disembark',
                                    name: 'disembark'
                                },
                                {
                                    data: 'days',
                                    name: 'days'
                                },
                                {
                                    data: 'nights',
                                    name: 'nights'
                                },
                                {
                                    data: 'ship_name',
                                    name: 'ship_name'
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
