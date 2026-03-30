@extends('admins.master')

@section('permission', 'active')

@section('title', 'Demand Detail')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="card-header flex-column flex-md-row border-bottom p-0">
                        <div class="row m-0 pb-2 mb-2">
                            <div class="col-sm-6 p-0">
                                <div class="head-label">
                                    <h5 class="card-title mb-0 pt-2">Permissions</h5>
                                </div>
                            </div>
                            <div class="col-sm-4 p-0">
                            </div>
                            <div class="col-sm-2 p-0">
                                <div class="head-label">
                                    <a href="{{ route('admins.permissions.create') }}" class="btn btn-primary">Create New
                                        Permissions</a>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->module_name }}</td>
                                            <td>
                                                <a href="{{ route('admins.permissions.edit', $permission->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('admins.permissions.destroy', $permission->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
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
