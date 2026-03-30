@extends('admins.master')

@section('inventory_request_active', 'active')

@section('title', 'Inventory Requests')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="card-header flex-column flex-md-row border-bottom p-0">
                        <div class="row m-0 pb-2 mb-2">
                            <div class="col-sm-6 p-0">
                                <div class="head-label">
                                    <h5 class="card-title mb-0 pt-2">Inventory Requests</h5>
                                </div>
                            </div>
                            <div class="col-sm-4 p-0">
                            </div>
                            <div class="col-sm-2 p-0">
                                <div class="head-label">
                                    <a href="{{ route('admins.inventory-requests.create') }}" class="btn btn-primary">Create New Request</a>
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
                                        <th>Pickup Warehouse</th>
                                        <th>Dropoff Warehouse</th>
                                        <th>Status</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $request->pickupWarehouse->name ?? '--' }}</td>
                                            <td>{{ $request->dropoffWarehouse->name ?? '--' }}</td>
                                            <td>{{ ucfirst($request->status) }}</td>
                                            <td>{{ date('F j, Y', strtotime($request->created_at)) }}</td>
                                            <td>
                                                <a href="{{ route('admins.inventory-requests.show', $request->id) }}" class="btn btn-sm btn-primary">View</a>
                                                <a href="{{ route('admins.inventory-requests.edit', $request->id) }}" class="btn btn-sm btn-primary">edit</a>
                                                <form action="{{ route('admins.inventory-requests.destroy', $request->id) }}" method="POST" style="display:inline;">
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