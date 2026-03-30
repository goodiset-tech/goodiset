@extends('admins.master')

@section('inventory_request_active', 'active')

@section('title', 'Inventory Request Details')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Inventory Request Details</h5>
                    </div>
                    <div class="ibox-content">
                        <!-- Add this to your index or show view -->
                        <form action="{{ route('admins.inventory-requests.update-status', $inventoryRequest->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="pending" {{ $inventoryRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $inventoryRequest->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $inventoryRequest->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>
                        <div class="form-group">
                            <label>Pickup Warehouse:</label>
                            <p>{{ $inventoryRequest->pickupWarehouse->name }}</p>
                        </div>
                        <div class="form-group">
                            <label>Dropoff Warehouse:</label>
                            <p>{{ $inventoryRequest->dropoffWarehouse->name }}</p>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <p>{{ ucfirst($inventoryRequest->status) }}</p>
                        </div>
                        <div class="form-group">
                            <label>Created at:</label>
                            <p>{{ date('F j, Y', strtotime($inventoryRequest->created_at)) }}</p>
                        </div>
                        <h4>Requested Products</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventoryRequest->items as $item)
                                    <tr>
                                        <td>{{ $item->product->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('admins.inventory-requests.index') }}" class="btn btn-default">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection