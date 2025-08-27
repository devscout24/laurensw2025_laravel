@extends('backend.app')

@section('title', 'Bookings Two List')

@push('style')
    <link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <style>
        #data-table th,
        #data-table td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    <main class="app-content content">
        <div class="row">
            <div class="col-lg-12 mb-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">Bookings Two List</h4>
                    </div>
                    <div class="card-body">
                        <table id="data-table" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Trip</th>
                                    <th>Cabin</th>
                                    <th>Status</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script src="{{ asset('backend/assets/datatable/js/datatables.min.js') }}"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });

            if (!$.fn.DataTable.isDataTable('#data-table')) {
                $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('booking-two.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'user',
                            name: 'user.name'
                        },
                        {
                            data: 'trip',
                            name: 'tripTwo.name'
                        },
                        {
                            data: 'cabin',
                            name: 'cabinTwo.title'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount'
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

        function updateBookingStatus(id, status) {
            console.log("Updating booking", id, status);
            $.ajax({
                url: '{{ route('booking-two.status', ':id') }}'.replace(':id', id),
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Booking status updated to ' + status
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to update status'
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    });
                }
            });
        }
    </script>
@endpush
