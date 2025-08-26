@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/datatable/css/datatables.min.css') }}">
@endpush
@section('title', 'Home Tour List')
@section('content')
    <div class="app-content content ">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Home Tour List</h3>
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('homeTour.create') }}" class="btn btn-info btn-sm">Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Header</th>
                                <th>Title</th>
                                <th>Duration</th>
                                <th>Ship</th>
                                <th>Price</th>
                                <th>Image</th>
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
                        ajax: "{{ route('homeTour.getData') }}",
                        columns: [{
                                data: 'header',
                                name: 'header'
                            },
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'duration',
                                name: 'duration',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'ship',
                                name: 'ship',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'price',
                                name: 'price',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'image',
                                name: 'image',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                }
            });

        });
        </script>
    @endpush
@endsection
