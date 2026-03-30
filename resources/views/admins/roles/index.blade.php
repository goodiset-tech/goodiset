@extends('admins.master')

@section('roles', 'active')

@section('title', 'Roles')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Roles List</h5>
                        <div class="ibox-tools">
                            <button class="btn btn-primary btn-sm text-white">
                                <a href="{{ route('admins.roles.create') }}" style="color: white;">Add Role</a>
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <a href="{{ route('admins.roles.edit', $role->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                @if ($role->name != 'Super Admin')
                                                    <form action="{{ route('admins.roles.destroy', $role->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                @endif
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
