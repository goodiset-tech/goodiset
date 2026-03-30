@extends('admins.master')

@section('warehouse_active', 'active')

@section('title', 'Warehouses')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="card-header flex-column flex-md-row border-bottom p-0">
                        <div class="row m-0 pb-2 mb-2">
                            <div class="col-sm-6 p-0">
                                <div class="head-label">
                                    <h5 class="card-title mb-0 pt-2">Warehouses</h5>
                                </div>
                            </div>
                            <div class="col-sm-4 p-0">
                            </div>
                            <div class="col-sm-2 p-0">
                                <div class="head-label">
                                    <a href="{{ route('admins.warehouses.create') }}" class="btn btn-primary">Create New Warehouse</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr #</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Location Name</th>
                                        <th>Address</th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Phone</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($warehouses as $warehouse)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $warehouse->name }}</td>
                                            <td>{{ ucfirst($warehouse->type) }}</td>
                                            <td>{{ $warehouse->location_name ?? '--' }}</td>
                                            <td>{{ $warehouse->address }}</td>
                                            <td>{{ $warehouse->contact_name }}</td>
                                            <td>{{ $warehouse->contact_email }}</td>
                                            <td>{{ $warehouse->contact_phone }}</td>
                                            <td>{{ date('F j, Y', strtotime($warehouse->created_at)) }}</td>
                                            <td>
                                                <a href="{{ route('admins.warehouses.edit', $warehouse->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('admins.warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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