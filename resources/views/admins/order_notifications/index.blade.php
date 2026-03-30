@extends('admins.master')

@section('order_notifications', 'active')
@section('title', 'Order Notifications')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Order Notification List</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('admins.order_notifications.create') }}" class="btn btn-primary btn-xs">Add Notification</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr = 1; @endphp
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $notification->name }}</td>
                                            <td>{{ $notification->email }}</td>
                                            <td>
                                                <div class="switch">
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" name="notification_status"
                                                            data-id="{{ $notification->id }}"
                                                            {{ $notification->status == 'active' ? 'checked' : '' }}
                                                            class="onoffswitch-checkbox" id="notification-{{ $notification->id }}">
                                                        <label class="onoffswitch-label" for="notification-{{ $notification->id }}">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('admins.order_notifications.edit', $notification->id) }}" class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)" data-href="{{ route('admins.order_notifications.destroy', $notification->id) }}" class="btn btn-danger delete_record">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', '.onoffswitch-checkbox', function() {
                var notification_id = $(this).data('id');
                var status = $(this).is(':checked') ? 'active' : 'inactive';
                updateStatus(status, notification_id);
            });

            function updateStatus(status, notification_id) {
                if (notification_id > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        url: "{{ route('admins.order_notifications.toggle-status') }}",
                        type: "POST",
                        data: {
                            notification_id: notification_id,
                            status: status,
                        },
                        success: function(response) {
                            showToastr(response.msg, response.msg_type);
                        }
                    });
                }
            }
        });
    </script>
@endpush