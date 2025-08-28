@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/datatable/css/datatables.min.css') }}">
@endpush

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
                                {{-- <th>ID</th> --}}
                                <th>Trip Name</th>
                                <th>Ship Name</th>
                                <th>Destinations</th>
                                <th>Cabins Count</th>
                                <th>Gallery Count</th>
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
                            ajax: "{{ route('trips.getDataList') }}",
                            columns: [{
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'ship_name',
                                    name: 'ship_name'
                                },
                                {
                                    data: 'destinations',
                                    name: 'destinations'
                                },
                                {
                                    data: 'cabins_count',
                                    name: 'cabins_count'
                                },
                                {
                                    data: 'gallery_count',
                                    name: 'gallery_count'
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
