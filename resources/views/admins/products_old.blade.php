<style>
    td {
        vertical-align: middle !important;
    }

    td img {
        width: 50px;
    }
</style>
@extends('admins.master')

@section('title', 'Products')

@section('product_active', 'active')

@section('product_active_c1', 'collapse in')

@section('product_child_2_active', 'active')


<?php
use App\Models\Admins\Category;
use App\Models\Admins\SubCategory;
use App\Models\Childcatagorie;
use App\Models\product;
use App\Models\Admins\Gallerie;
use App\Models\Format;
?>

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5>Product List</h5>
                                <div class="ibox-tools">

                                </div>
                            </div>
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-4" style="display: flex;justify-content: end;flex-wrap: wrap;">
                                <form action="{{ route('admins.products.export') }}" method="GET" class="mb-3">
                                    <button type="submit" class="btn btn-md btn-primary">Export </button>
                                </form>
                                <button type="button" style=" max-height: max-content;margin-left: 5;"
                                    class="btn btn-md btn-primary"><a style="color: white;"
                                        href="{{ route('admins.products.import.export') }}">Import </a></button>
                                <button type="button" style=" max-height: max-content;margin-left: 5;"
                                    class="btn btn-md btn-primary"><a href="{{ route('admins.product_form') }}"
                                        style="color: white;">Add </a></button>
                            </div>
                        </div>

                    </div>

                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="productTable" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>

                                            <th>Image</th>
                                            {{-- <th>Product Code</th> --}}
                                            <th>Product Name</th>
                                            <th>Sort Order</th>
                                            <th>Category</th>
                                            {{-- <th>Sub Category</th> --}}
                                            <th>Format</th>
                                            <th>Price</th>
                                            <th>Sale Price</th>
                                            {{-- <th>Weight</th>
                                            <th>Total Weight</th> --}}
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th style="display: none;"></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th></th> <!-- Image -->
                                            <th></th> <!-- Product Code -->
                                            <th></th> <!-- Product Name -->
                                            <th>
                                                <select id="categoryFilter" class="form-control">
                                                    <option value="">All Categories</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            {{-- <th></th> <!-- Sub Category --> --}}
                                            <th>
                                                <select id="formatFilter" class="form-control">
                                                    <option value="">All Formats</option>
                                                    @foreach ($formats as $format)
                                                        <option value="{{ $format->name }}">{{ $format->name }}</option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th></th> <!-- Price -->
                                            <th></th> <!-- Sale Price -->
                                            {{-- <th></th> <!-- Weight -->
                                            <th></th> <!-- Total Weight --> --}}
                                            <th></th> <!-- Quantity -->
                                            <th>
                                                <select id="statusFilter" class="form-control">
                                                    <option value="">All Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </th>
                                            <th style="display: none;"></th>
                                            <th></th> <!-- Action -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>

                                                <td><img src="{{ asset($product->image_one) }}" alt=""></td>
                                                {{-- <td>{{ $product->product_code }}</td> --}}
                                                <td>{{ $product->product_name }}</td>
                                                <td>
                                                    <input type="number" class="form-control sort-order-input"
                                                        data-id="{{ $product->id }}"
                                                        value="{{ $product->sort_order ?? 0 }}" style="width: 80px;">
                                                </td>
                                                <?php
                                                $category_ids = explode(',', $product->category_id); // Convert "1,3" into [1, 3]
                                                $categories = Category::whereIn('id', $category_ids)->get();
                                                ?>

                                                <td>
                                                    {{ $categories->pluck('name')->implode(', ') }}
                                                </td>
                                                <?php
                                                $sub_category_id = SubCategory::where(['id' => $product->sub_category_id])->first();
                                                ?>

                                                {{-- <td>{{ isset($sub_category_id->name) ? $sub_category_id->name : '' }}</td> --}}
                                                <?php
                                                $format = Format::where(['id' => $product->format])->first();
                                                ?>

                                                <td>{{ isset($format->name) ? $format->name : '' }}</td>
                                                <td>{{ getSetting('currency') . ' ' . $product->discount_price }}</td>
                                                <td>{{ getSetting('currency') . ' ' . $product->selling_price }}</td>
                                                {{-- <td>{{ $product->weight ?? '' }}</td>
                                                <td>{{ $product->total_weight ?? '' }}</td> --}}
                                                <td>{{ $product->product_quantity }}</td>
                                                <td>
                                                    <div class="switch">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" name="product_status"
                                                                data-id="{{ $product->id }}"
                                                                {{ $product->status == 1 ? 'checked' : '' }}
                                                                class="onoffswitch-checkbox"
                                                                id="example-{{ $product->id }}">
                                                            <label class="onoffswitch-label"
                                                                for="example-{{ $product->id }}">
                                                                <span class="onoffswitch-inner"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p id="status" style="display: none;">
                                                        <?= $product->status == 1 ? 'checked' : 'unchecked' ?></p>
                                                </td>
                                                <td style="display: none;">
                                                    <?= $product->status == 1 ? 'checked' : 'unchecked' ?>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admins.product_form', $product->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-edit"></i>&nbsp;Edit
                                                    </a>
                                                    <a data-href="{{ route('admins.product_delete', ['id' => $product->id]) }}"
                                                        class="btn btn-danger btn-sm delete_record"
                                                        href="javascript:void(0)">
                                                        <i class="fa fa-times"></i>&nbsp;Delete
                                                    </a>
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
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#productTable').DataTable();

            // Apply custom filtering for category
            $('#categoryFilter').on('change', function() {
                table.column(3).search(this.value).draw(); // Category column (Index 3)
            });

            // Apply custom filtering for format
            $('#formatFilter').on('change', function() {
                table.column(4).search(this.value).draw(); // Format column (Index 5)
            });

            // Apply custom filtering for status
            $('#statusFilter').on('change', function() {
                var filterValue = this.value; // Get selected filter value
                console.log('Filter Value:', filterValue);

                // Use the DataTables custom search feature
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    var statusText = $(table.row(dataIndex).node()).find('#status')
                .text(); // Extract status from hidden <p>
                    console.log('Row Status:', statusText);

                    if (filterValue === '') {
                        return true; // Show all rows if no filter is applied
                    } else if (filterValue === '1' && statusText === 'checked') {
                        return true; // Include rows with 'checked' status
                    } else if (filterValue === '0' && statusText === 'unchecked') {
                        return true; // Include rows with 'unchecked' status
                    }
                    return false; // Exclude rows that don't match the filter
                });

                // Redraw the DataTable
                table.draw();

                // Remove custom search filter after applying
                $.fn.dataTable.ext.search.pop();
            });
        });

        function updateStatus(status, product_id) {
            if (product_id > 0) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    url: "{{ route('admins.update_product_status') }}",
                    type: "POST",
                    data: {
                        product_id: product_id,
                        Status: status,
                    },
                    success: function(response) {
                        showToastr(response.msg, response.msg_type);
                    }
                });
            }
        }

        $(document).ready(function() {
            $(document).on("change", ".sort-order-input", function() {
                var productId = $(this).data("id");
                var sortOrder = $(this).val();

                $.ajax({
                    url: "{{ route('admins.update_sort_order') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: productId,
                        sort_order: sortOrder
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("Sort order updated successfully!");
                        } else {
                            alert("Failed to update sort order.");
                        }
                    },
                    error: function() {
                        alert("An error occurred.");
                    }
                });
            });
        });
    </script>
@endpush
