@extends('admins.master')

@section('users', 'active')

@section('title', 'Users')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Users List</h5>
                        <div class="ibox-tools">
                            <button class="btn btn-primary btn-sm text-white">
                                <a href="{{ route('admins.users.create') }}" style="color: white;">Add User</a>
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                                            <td>
                                                <a href="{{ route('admins.users.edit', $user->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                @if (implode(', ', $user->roles->pluck('name')->toArray()) != 'Super Admin')
                                                    <form action="{{ route('admins.users.destroy', $user->id) }}"
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
    <!-- Content wrapper -->

@endsection
