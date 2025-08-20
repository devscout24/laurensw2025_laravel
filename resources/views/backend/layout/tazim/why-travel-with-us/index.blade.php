@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/datatable/css/datatables.min.css') }}">
@endpush
@section('title', 'Premium Services & Inclusives List')
@section('content')
    <div class="app-content content ">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Premium Services & Inclusives List</h3>
                <a href="{{ route('whyTravelWithUs.create') }}" class="btn btn-info btn-sm">Add New</a>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Heading</th>
                                <th>Title</th>
                                <th>Description 1</th>
                                <th>Description 2</th>
                                <th>Description 3</th>
                                <th>Description 4</th>
                                <th style="width:10%">Action</th>
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
                        ajax: "{{ route('whyTravelWithUs.getData') }}",
                        columns: [{
                                data: 'header',
                                name: 'header'
                            },
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'description1',
                                name: 'description1'
                            },
                            {
                                data: 'description2',
                                name: 'description2'
                            },
                            {
                                data: 'description3',
                                name: 'description3'
                            },
                            {
                                data: 'description4',
                                name: 'description4'
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
