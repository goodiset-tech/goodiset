@extends('admins.master')

@section('user', 'active')

@section('title', 'Demand Detail')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit User</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" action="{{ route('admins.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Name</label>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                        placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Email</label>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}"
                                        placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Password</label>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="password" placeholder="Enter Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">User Roles</label>
                                <div class="col-lg-12">
                                    @foreach ($roles as $role)
                                        <input type="radio" name="roles[]"
                                            {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}
                                            value="{{ $role->id }}" id="">
                                        <label for="">{{ $role->name }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
