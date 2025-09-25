@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/datatable/css/datatables.min.css') }}">
@endpush

@section('title', 'Ship Cabin List')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <div class="app-content content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ship Cabin List</h3>
                <a href="{{ route('shipDeck.create') }}" class="btn btn-primary btn-sm">Add Deck</a>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4 p-4 card-datatable pt-0">
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Ship Name</th>
                                <th>Image Title</th>
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
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                });

                if (!$.fn.DataTable.isDataTable('#data-table')) {
                    $('#data-table').DataTable({
                        order: [],
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        processing: true,
                        serverSide: true,
                        responsive: true,

                        language: {
                            processing: `<div class="text-center">
                                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>`
                        },

                        pagingType: "full_numbers",
                        ajax: {
                            url: "{{ route('shipDeck.index') }}",
                            type: "GET",
                        },
                        columns: [
                            {
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },                            
                            {
                                data: 'ship',
                                name: 'ship'
                            },
                            {
                                data: 'title',
                                name: 'title'
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

            // delete Confirm
            function showDeleteConfirm(id) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure you want to delete ?',
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

            // Delete function
            function deleteItem(id) {
                let url = '{{ route('shipDeck.destroy', ':id') }}';
                let csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    type: "GET",
                    url: url.replace(':id', id),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(resp) {
                        $('#data-table').DataTable().ajax.reload();

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: resp.success ? 'success' : 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    error: function() {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'An error occurred. Please try again.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
