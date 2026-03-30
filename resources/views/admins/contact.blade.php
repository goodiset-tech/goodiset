<style>
    td {
        vertical-align: middle !important;
    }

    td img {
        width: 50px;
    }

    .action-btn {
        margin: 0 2px;
    }

    .modal-body textarea {
        width: 100%;
        min-height: 150px;
    }
</style>
@extends('admins.master')

@section('title', $type)
@section($type, 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Message List</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="mr-2 mb-0">Quick filter:</label>
                                    <select id="periodFilter" class="form-control">
                                        <option value="all" selected>All</option>
                                        <option value="today">Today</option>
                                        <option value="this_week">This Week</option>
                                        <option value="this_month">This Month</option>
                                        <option value="last_7">Last 7 Days</option>
                                        <option value="last_30">Last 30 Days</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="mr-2 mb-0">Custom:</label>
                                    <input type="date" id="fromDate" class="form-control ">
                                    <span class="mx-1">to</span>
                                    <input type="date" id="toDate" class="form-control ">
                                    <button id="applyCustomRange"
                                        class="btn btn-sm btn-outline-secondary ml-2">Apply</button>
                                    <button id="clearCustomRange" class="btn btn-sm btn-link">Clear</button>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <button id="previewSpamBtn" class="btn btn-sm btn-outline-warning">
                                    <i class="fa fa-search"></i> Preview spam count
                                </button>
                                <button id="clearSpamBtn" class="btn btn-sm btn-warning">
                                    <i class="fa fa-broom"></i> Clear spam (keywords)
                                </button>
                            </div>

                        </div>
                        <form method="POST" action="{{ route('admins.delete_contact') }}" id="deleteSelectedForm">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete
                                Selected</button>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="messageTable">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select_all"></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Message</th>
                                            <th>Submitted At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody> <!-- Data will be loaded via AJAX -->
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to <span id="replyName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="replyForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="contact_id" id="contactId">
                        <input type="hidden" name="to_email" id="toEmail">
                        <div class="form-group">
                            <label for="replyMessage">Your Reply:</label>
                            <textarea class="form-control" name="message" id="replyMessage" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="sendReplyBtn">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // State for filters
            let currentPeriod = 'all';
            let currentFrom = '';
            let currentTo = '';

            // Initialize DataTable with server-side processing
            let table = $('#messageTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admins.contact.datatable') }}",
                    data: function(d) {
                        d.type = "{{ $type }}";
                        d.period = currentPeriod;
                        if (currentFrom && currentTo) {
                            d.from = currentFrom;
                            d.to = currentTo;
                        }
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'meg',
                        name: 'meg'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Period filter
            $('#periodFilter').on('change', function() {
                currentPeriod = $(this).val();
                // Clear custom range if user picked a quick filter
                if (currentPeriod !== 'all') {
                    currentFrom = currentTo = '';
                    $('#fromDate, #toDate').val('');
                }
                table.ajax.reload(null, false);
            });

            // Custom range apply/clear
            $('#applyCustomRange').on('click', function(e) {
                e.preventDefault();
                const f = $('#fromDate').val();
                const t = $('#toDate').val();
                if (!f || !t) {
                    return swal("Select both dates", "Please choose both start and end dates.", "info");
                }
                currentFrom = f;
                currentTo = t;
                currentPeriod = 'all'; // custom overrides quick
                $('#periodFilter').val('all');
                table.ajax.reload(null, false);
            });

            $('#clearCustomRange').on('click', function(e) {
                e.preventDefault();
                currentFrom = currentTo = '';
                $('#fromDate, #toDate').val('');
                table.ajax.reload(null, false);
            });

            // Select all checkboxes
            $('#select_all').on('click', function() {
                $(".emp_checkbox").prop("checked", this.checked);
                $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
            });

            // Individual checkbox handling
            $('#messageTable').on('click', '.emp_checkbox', function() {
                $('#select_all').prop('checked', $('.emp_checkbox:checked').length === $('.emp_checkbox')
                    .length);
                $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
            });

            // Reply button handler
            $('#messageTable').on('click', '.reply-btn', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const name = $(this).data('name');

                $('#contactId').val(id);
                $('#toEmail').val(email);
                $('#replyName').text(name);
                $('#replyMessage').val('');
                $('#replyModal').modal('show');
            });

            // Reply form submission
            $('#replyForm').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admins.send_contact_reply') }}",
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#sendReplyBtn').attr('disabled', true).text('Sending...');
                    },
                    success: function(response) {
                        if (response.success) {
                            swal("Success", "Reply sent successfully!", "success");
                            $('#replyModal').modal('hide');
                        } else {
                            let errorMessage = response.message || "Failed to send reply";
                            if (response.error) errorMessage += "\nError: " + response.error;
                            swal("Error", errorMessage, "error");
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = "An error occurred while sending the reply";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage += "\nError: " + xhr.responseJSON.error;
                        }
                        swal("Error", errorMessage, "error");
                    },
                    complete: function() {
                        $('#sendReplyBtn').attr('disabled', false).text('Send Reply');
                    }
                });
            });

            // Delete single message via AJAX
            $('#messageTable').on('click', '.delete_record1', function(e) {
                e.preventDefault();
                const deleteUrl = $(this).data('href');

                swal({
                    title: "Are you sure?",
                    text: "This message will be deleted permanently!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: deleteUrl,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload(null, false);
                                    swal("Deleted!", "The message has been deleted.",
                                        "success");
                                } else {
                                    swal("Error", response.message ||
                                        "Failed to delete the message", "error");
                                }
                            },
                            error: function(xhr) {
                                let errorMessage =
                                    "An error occurred while deleting the message";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                swal("Error", errorMessage, "error");
                            }
                        });
                    }
                });
            });

            // CLEAR SPAM BUTTON
            // PREVIEW how many will be deleted
            $('#previewSpamBtn').on('click', function(e) {
                e.preventDefault();
                $.get("{{ route('admins.contact.clear_spam.count') }}", {
                        type: "{{ $type }}"
                    })
                    .done(function(res) {
                        if (res.success) {
                            swal("Spam preview", "Will remove: " + res.count + " message(s).", "info");
                        } else {
                            swal("Error", "Failed to count spam.", "error");
                        }
                    })
                    .fail(function() {
                        swal("Error", "Failed to count spam.", "error");
                    });
            });

            // CLEAR spam now
            $('#clearSpamBtn').on('click', function(e) {
                e.preventDefault();
                swal({
                    title: "Clear spam?",
                    text: "This deletes messages with links OR spam keywords (e.g., «ссылке», «уже», «подарок», …).",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((ok) => {
                    if (!ok) return;
                    $.post("{{ route('admins.contact.clear_spam') }}", {
                            _token: '{{ csrf_token() }}',
                            type: "{{ $type }}"
                        })
                        .done(function(res) {
                            if (res.success) {
                                $('#messageTable').DataTable().ajax.reload(null, false);
                                swal("Done", res.message, "success");
                            } else {
                                swal("Error", "Failed to clear spam.", "error");
                            }
                        })
                        .fail(function() {
                            swal("Error", "Failed to clear spam.", "error");
                        });
                });
            });

        });
    </script>
@endpush
