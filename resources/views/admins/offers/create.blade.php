@extends('admins.master')

@section('title', 'Offers')

@section('offer_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Offer Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post"
                            action="{{ isset($edit) ? route('admins.offers.update', $edit->id) : route('admins.offers.store') }}">
                            @csrf
                            @if (isset($edit))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Offer Name</label>
                                <div class="col-lg-9">
                                    <input type="text" required name="name"
                                        value="{{ isset($edit->name) ? $edit->name : '' }}" class="form-control">
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Discount Type</label>
                                <div class="col-lg-9">
                                    <select name="discount_type" class="form-control" required>
                                        <option value="amount"
                                            {{ isset($edit->type) && $edit->type == 'amount' ? 'selected' : '' }}>Amount
                                        </option>
                                        <option value="percentage"
                                            {{ isset($edit->type) && $edit->type == 'percentage' ? 'selected' : '' }}>
                                            Percentage</option>
                                    </select>
                                    @error('discount_type')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Apply on Discounted?</label>
                                <div class="col-lg-9">
                                    <select name="apply_on_discounted" class="form-control" required>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    <span class="help-block m-b-none">If Yes, new discount will be calculated based on the
                                        current selling price (Compare Price).</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Discount</label>
                                <div class="col-lg-9">
                                    <input type="number" required name="discount"
                                        value="{{ isset($edit->discount) ? $edit->discount : '' }}" class="form-control">
                                    @error('discount')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Select Category</label>
                                <div class="col-lg-9">
                                    <select id="categorySelect" class="form-control">
                                        <option value="">Select a Category</option>
                                        <option value="all">All Categories</option>
                                        @foreach (App\Models\Admins\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block m-b-none">Select a category to filter products below.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Select Products</label>
                                <div class="col-lg-9">
                                    <div class="m-b-sm">
                                        <button type="button" id="selectAllProducts" class="btn btn-xs btn-primary">Select
                                            All</button>
                                        <button type="button" id="deselectAllProducts"
                                            class="btn btn-xs btn-warning">Deselect All</button>
                                    </div>
                                    <select class="js-example-basic-multiple" name="products[]" multiple="multiple"
                                        style="width: 100%">
                                        @foreach ($products as $product)
                                            @php
                                                if (isset($edit)) {
                                                    $products_ids = json_decode($edit->product_ids);
                                                } else {
                                                    $products_ids = [];
                                                }
                                            @endphp
                                            <option value="{{ $product->id }}"
                                                {{ isset($edit) && in_array($product->id, $products_ids) ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('products')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Start Date</label>
                                <div class="col-lg-9">
                                    <input type="date" name="start_date"
                                        value="{{ isset($edit->start_date) ? $edit->start_date : '' }}"
                                        class="form-control">
                                    @error('start_date')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">End Date</label>
                                <div class="col-lg-9">
                                    <input type="date" name="end_date"
                                        value="{{ isset($edit->end_date) ? $edit->end_date : '' }}" class="form-control">
                                    @error('end_date')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if (isset($edit->id))
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Status</label>
                                    <div class="col-lg-9">
                                        <select name="status" class="form-control" required>
                                            <option value="1"
                                                {{ isset($edit->status) && $edit->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0"
                                                {{ isset($edit->status) && $edit->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif

                            <div class="form-group">
                                <label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9">
                                    <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize Select2 for Products
                const $select = $('.js-example-basic-multiple').select2({
                    placeholder: "Select products",
                    allowClear: true,
                    width: '100%'
                });

                // Initialize Select2 for Category
                $('#categorySelect').select2({
                    placeholder: "Select a Category",
                    allowClear: true,
                    width: '100%'
                });

                // Handle Category Change
                $('#categorySelect').on('change', function() {
                    var categoryId = $(this).val();
                    if (categoryId) {
                        $.ajax({
                            url: "{{ route('admins.offers.get_products_by_category') }}",
                            type: "POST",
                            data: {
                                category_id: categoryId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                var products = response.products;
                                var selectedIds = $select.val() || [];

                                // Get current selected options to preserve them
                                var preservedOptions = [];
                                $select.find('option:selected').each(function() {
                                    preservedOptions.push({
                                        id: $(this).val(),
                                        text: $(this).text()
                                    });
                                });

                                // Clear existing options
                                $select.empty();

                                // Re-add preserved options
                                preservedOptions.forEach(function(opt) {
                                    var option = new Option(opt.text, opt.id, true, true);
                                    $select.append(option);
                                });

                                // Populate with new products
                                $.each(products, function(index, product) {
                                    // Add only if not already preserved
                                    if (!selectedIds.includes(product.id.toString())) {
                                        var productName = product.product_name;
                                        // Product discount logic removed as per user request
                                        var option = new Option(productName, product.id,
                                            false, false);
                                        $select.append(option);
                                    }
                                });
                                $select.trigger('change');
                            },
                            error: function(xhr) {
                                console.log('Error:', xhr);
                            }
                        });
                    }
                });

                // Select All button functionality
                $('#selectAllProducts').click(function() {
                    // Get all option values
                    let allValues = [];
                    $('.js-example-basic-multiple option').each(function() {
                        allValues.push($(this).val());
                    });
                    // Set all values to the Select2
                    $select.val(allValues).trigger('change');
                });

                // Deselect All button functionality
                $('#deselectAllProducts').click(function() {
                    // Clear all selections
                    $select.val(null).trigger('change');
                });
            });
        </script>
    @endpush
@endsection
