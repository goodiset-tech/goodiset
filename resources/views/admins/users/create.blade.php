@extends('admins.master')

@section('users', 'active')

@section('title', 'Demand Detail')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create User</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" action="{{ route('admins.users.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Name</label>
                                <div class="col-lg-12">
                                    <input type="text" required name="name" value="Enter Name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Email</label>
                                <div class="col-lg-12">
                                    <input type="text" required name="email" value="Enter Email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Password</label>
                                <div class="col-lg-12">
                                    <input type="text" required name="password" value="Enter Password"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Roles</label>
                                <div class="col-lg-12">
                                    @foreach ($roles as $role)
                                        <input type="radio" name="roles[]" value="{{ $role->id }}"
                                            id="{{ $role->name }}">
                                        <label for="{{ $role->name }}">{{ $role->name }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->

@endsection
