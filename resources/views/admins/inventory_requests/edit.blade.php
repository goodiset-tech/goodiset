@extends('admins.master')

@section('inventory_request_active', 'active')
@section('title', 'Edit Inventory Request')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit Inventory Request</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admins.inventory-requests.update', $inventoryRequest->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="pickup_warehouse_id">Pickup Warehouse</label>
                                    <select name="pickup_warehouse_id" id="pickup_warehouse_id" class="form-control" required>
                                        <option value="">Select Pickup Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ $inventoryRequest->pickup_warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="dropoff_warehouse_id">Dropoff Warehouse</label>
                                    <select name="dropoff_warehouse_id" id="dropoff_warehouse_id" class="form-control" required>
                                        <option value="">Select Dropoff Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ $inventoryRequest->dropoff_warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Products</label>
                                <div id="product-fields">
                                    @foreach ($inventoryRequest->items as $index => $item)
                                        <div class="row product-field mt-2">
                                            <div class="col-md-3">
                                                <select name="products[{{ $index }}][product_id]" class="form-control product-select" required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="products[{{ $index }}][quantity]" class="form-control" min="1" placeholder="Quantity" value="{{ $item->quantity }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="products[{{ $index }}][unit]" class="form-control"  placeholder="Unit" value="{{ $item->unit }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                @if ($index == 0)
                                                    <button type="button" id="add-product" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-product"><i class="fa fa-times"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="users">Notify Users</label>
                                <select name="users[]" id="users" class="form-control" multiple="multiple" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ in_array($user->id, $inventoryRequest->users ?? []) ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.product-select').select2();
        $('#users').select2();

        document.getElementById('add-product').addEventListener('click', function () {
            const productFields = document.getElementById('product-fields');
            const index = productFields.children.length;
            const newField = document.createElement('div');
            newField.classList.add('row', 'product-field', 'mt-2');
            newField.innerHTML = `
                <div class="col-md-3">
                    <select name="products[${index}][product_id]" class="form-control product-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[${index}][quantity]" min="1" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="products[${index}][unit]" class="form-control" placeholder="Unit" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-product"><i class="fa fa-times"></i></button>
                </div>
            `;
            productFields.appendChild(newField);
            $('.product-select').select2();

            // Add event listener to the new remove button
            newField.querySelector('.remove-product').addEventListener('click', function() {
                productFields.removeChild(newField);
            });
        });

        // Handle removal of existing product fields
        $(document).on('click', '.remove-product', function() {
            $(this).closest('.product-field').remove();
        });
    });
</script>
@endpush