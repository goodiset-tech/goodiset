@extends('admins.master')

@section('order_notifications', 'active')
@section('title', 'Add Order Notification')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Order Notification</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('admins.order_notifications.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Notification</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection