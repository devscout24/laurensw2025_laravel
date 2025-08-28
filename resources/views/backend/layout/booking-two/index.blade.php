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
    <div class="app-content content ">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Booking Two Trip List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable table-responsive pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Trip</th>
                                <th>Cabin</th>
                                <th>Status</th>
                                <th>Cabin Price</th>
                                <th>Booking Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'mobile'
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
                            data: 'date',
                            name: 'date'
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

        // Status update
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

        // Delete Booking
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure want to delete this ?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        // Delete Button
        function deleteItem(id) {
            let url = '{{ route('booking-two.destroy', ':id') }}';
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    $('#data-table').DataTable().ajax.reload();

                    if (resp.success) {
                        Toast.fire({
                            icon: 'success',
                            title: resp.message
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: resp.message
                        });
                    }
                },
                error: function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'An error occurred. Please try again.'
                    });
                }
            });
        }
    </script>
@endpush
