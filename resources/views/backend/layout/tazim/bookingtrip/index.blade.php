@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/datatable/css/datatables.min.css') }}">
@endpush
@section('title', 'Cutomer Message')
@section('content')
    <div class="app-content content ">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Message List</h3>
                {{-- <a href="{{ route('getInTouch.create') }}" class="btn btn-info btn-sm">Add New</a> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                {{-- <th>
                                    <div class="form-checkbox">
                                        <input type="checkbox" class="form-check-input" id="select_all"
                                            onclick="select_all()">
                                        <label class="form-check-label" for="select_all"></label>
                                    </div>
                                </th> --}}
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Additional Note</th>
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
                        ajax: "{{ route('bookingTrip.getData') }}",
                        columns: [{
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'email',
                                name: 'email'
                            },
                            {
                                data: 'mobile',
                                name: 'mobile',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'country',
                                name: 'country',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'gender',
                                name: 'gender',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'date_of_birth',
                                name: 'date_of_birth',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'additional_note',
                                name: 'additional_note',
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
