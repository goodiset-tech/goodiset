@extends('admins.master')

@section('order_notifications', 'active')
@section('title', 'Edit Order Notification')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit Order Notification</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('admins.order_notifications.update', $notification->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $notification->name }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $notification->email }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ $notification->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $notification->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Notification</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection