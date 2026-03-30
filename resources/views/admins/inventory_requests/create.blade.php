@extends('admins.master')

@section('inventory_request_active', 'active')
@section('title', 'Create Inventory Request')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create New Inventory Request</h5>
                    </div>
                    <div class="ibox-content">
                        <!-- Display session errors or success -->
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admins.inventory-requests.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="pickup_warehouse_id">Pickup Warehouse</label>
                                    <select name="pickup_warehouse_id" id="pickup_warehouse_id" class="form-control" required>
                                        <option value="">Select Pickup Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('pickup_warehouse_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="dropoff_warehouse_id">Dropoff Warehouse</label>
                                    <select name="dropoff_warehouse_id" id="dropoff_warehouse_id" class="form-control" required>
                                        <option value="">Select Dropoff Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('dropoff_warehouse_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Products</label>
                                <div id="product-fields">
                                    <div class="row product-field">
                                        <div class="col-md-3">
                                            <select name="products[0][product_id]" class="form-control product-select" required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('products.0.product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="products[0][quantity]" min="1" class="form-control" placeholder="Quantity" required>
                                            @error('products.0.quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="products[0][unit]" class="form-control" placeholder="Unit" required>
                                            @error('products.0.unit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="add-product" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="users">Notify Users</label>
                                <select name="users[]" id="users" class="form-control" multiple="multiple" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == auth()->guard('admin')->user()->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Create Request</button>
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
            $('#users').select2({
                placeholder: "Select users to notify",
                minimumResultsForSearch: 1
            });

            const currentUserId = {{ auth()->guard('admin')->user()->id }};

            // Prevent deselection of current user
            $('#users').on('select2:unselecting', function(e) {
                if (e.params.args.data.id === currentUserId.toString()) {
                    e.preventDefault();
                }
            });

            // Ensure current user is included on form submission
            $('form').on('submit', function(e) {
                let selectedUsers = $('#users').val() || [];
                if (!selectedUsers.includes(currentUserId.toString())) {
                    selectedUsers.push(currentUserId.toString());
                    $('#users').val(selectedUsers).trigger('change');
                }
            });

            document.getElementById('add-product').addEventListener('click', function() {
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
                $(newField).find('.product-select').select2();

                newField.querySelector('.remove-product').addEventListener('click', function() {
                    productFields.removeChild(newField);
                });
            });

            $(document).on('click', '.remove-product', function() {
                $(this).closest('.product-field').remove();
            });
        });
    </script>
@endpush