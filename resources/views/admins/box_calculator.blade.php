@extends('admins.master')

@section('title', 'Box Customize')

@section('box_cal_active_c1', 'active')
@section('box_cal_active_c1', 'collapse in')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Box Calculator</h5>
                    </div>
                    <div class="ibox-content">
                        <form id="box-form" class="form-horizontal">
                            @csrf
                            <input type="hidden" id="box-id" name="box_id" value="{{ $box->id ?? '' }}">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Box Name:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="box_name" id="box-name" class="form-control"
                                        placeholder="Enter box name" value="{{ $box->box_name ?? '' }}">
                                    <span class="help-block m-b-none text-danger" id="name-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Box Weight (In grams):</label>
                                <div class="col-lg-9">
                                    <input type="number" name="weight" id="box-weight" class="form-control"
                                        value="{{ $box->box_weight ?? 1000 }}" min="500" placeholder="Enter weight (500g or more)">
                                    <span class="help-block m-b-none text-danger" id="weight-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Products:</label>
                                <div class="col-lg-9">
                                    <div id="product-list">
                                        @if (isset($box) && $box->products->isNotEmpty())
                                            @foreach ($box->products as $bp)
                                                <div class="product-row mb-2">
                                                    <select name="products[]" class="form-control product-select"
                                                        style="width: 40%; display: inline-block;">
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $p)
                                                            <option value="{{ $p->id }}" data-type="{{ $p->format }}"
                                                                data-quantity="{{ $p->product_quantity }}"
                                                                data-weight-per-unit="{{ $p->weight_per_unit }}"
                                                                {{ $p->id == $bp->product_id ? 'selected' : '' }}>
                                                                {{ $p->product_name }}
                                                                ({{ $p->format == 1 ? 'Pick & Mix' : 'Individual' }}, {{ $p->product_quantity }} available, {{ $p->weight_per_unit }}g per unit)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="number" name="percentages[]" class="form-control percentage-input"
                                                        placeholder="Percentage (%)" style="width: 20%; display: inline-block;"
                                                        min="0" max="100" value="{{ $bp->percentage }}">
                                                    <input type="text" class="form-control pieces-display" readonly
                                                        style="width: 20%; display: inline-block;" placeholder="Pieces" value="{{ $bp->pieces }}">
                                                    <button type="button" class="btn btn-sm btn-danger remove-product">Remove</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="product-row mb-2">
                                                <select name="products[]" class="form-control product-select"
                                                    style="width: 40%; display: inline-block;">
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $p)
                                                        <option value="{{ $p->id }}" data-type="{{ $p->format }}"
                                                            data-quantity="{{ $p->product_quantity }}"
                                                            data-weight-per-unit="{{ $p->weight_per_unit }}">
                                                            {{ $p->product_name }}
                                                            ({{ $p->format == 1 ? 'Pick & Mix' : 'Individual' }}, {{ $p->product_quantity }} available, {{ $p->weight_per_unit }}g per unit)
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="number" name="percentages[]" class="form-control percentage-input"
                                                    placeholder="Percentage (%)" style="width: 20%; display: inline-block;"
                                                    min="0" max="100">
                                                <input type="text" class="form-control pieces-display" readonly
                                                    style="width: 20%; display: inline-block;" placeholder="Pieces">
                                                <button type="button" class="btn btn-sm btn-danger remove-product">Remove</button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary add-product mt-2"><i class="fa fa-plus"></i></button>
                                    <span class="help-block m-b-none text-danger" id="products-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Calculated Boxes:</label>
                                <div class="col-lg-9">
                                    <input type="text" id="calculated-boxes" class="form-control" readonly
                                        value="0 boxes">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button type="button" class="btn btn-primary" id="save-box">Save Box</button>
                                    <a href="{{ route('admins.box.list') }}" class="btn btn-default">View Saved Boxes</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productList = document.getElementById('product-list');
            const addProductBtn = document.querySelector('.add-product');
            const boxWeightInput = document.getElementById('box-weight');
            const calculatedBoxesInput = document.getElementById('calculated-boxes');
            const weightError = document.getElementById('weight-error');
            const productsError = document.getElementById('products-error');
            const nameError = document.getElementById('name-error');
            const saveBoxBtn = document.getElementById('save-box');
            const boxNameInput = document.getElementById('box-name');
            const boxIdInput = document.getElementById('box-id');

            // Add new product row
            addProductBtn.addEventListener('click', function() {
                const productRow = document.createElement('div');
                productRow.className = 'product-row mb-2';
                productRow.innerHTML = `
                    <select name="products[]" class="form-control product-select" style="width: 40%; display: inline-block;">
                        <option value="">Select Product</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}" data-type="{{ $p->format }}" data-quantity="{{ $p->product_quantity }}"
                                data-weight-per-unit="{{ $p->weight_per_unit }}">
                                {{ $p->product_name }} ({{ $p->format == 1 ? 'Pick & Mix' : 'Individual' }}, {{ $p->product_quantity }} available, {{ $p->weight_per_unit }}g per unit)
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="percentages[]" class="form-control percentage-input" placeholder="Percentage (%)" style="width: 20%; display: inline-block;" min="0" max="100">
                    <input type="text" class="form-control pieces-display" readonly style="width: 20%; display: inline-block;" placeholder="Pieces">
                    <button type="button" class="btn btn-sm btn-danger remove-product">Remove</button>
                `;
                productList.appendChild(productRow);
                updateBoxCalculation();
            });

            // Remove product row
            productList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-product')) {
                    if (productList.children.length > 1) {
                        e.target.closest('.product-row').remove();
                        updateBoxCalculation();
                    }
                }
            });

            // Update calculation on input change
            productList.addEventListener('input', updateBoxCalculation);
            boxWeightInput.addEventListener('input', updateBoxCalculation);

            function updateBoxCalculation() {
                const boxWeight = parseFloat(boxWeightInput.value) || 0;
                const products = document.querySelectorAll('.product-select');
                const percentages = document.querySelectorAll('.percentage-input');
                const piecesDisplays = document.querySelectorAll('.pieces-display');

                // Reset error messages
                weightError.textContent = '';
                productsError.textContent = '';
                nameError.textContent = '';

                // Validate box weight
                if (boxWeight < 500) {
                    weightError.textContent = 'Box weight must be 500 grams or more.';
                    calculatedBoxesInput.value = '0 boxes';
                    piecesDisplays.forEach(display => display.value = '');
                    return;
                }

                let totalPercentage = 0;
                let totalWeightUsed = 0;
                let hasValidProduct = false;
                let maxBoxes = Infinity;

                products.forEach((select, index) => {
                    const percentage = parseFloat(percentages[index].value) || 0;
                    totalPercentage += percentage;

                    if (select.value && percentage > 0) {
                        hasValidProduct = true;
                        const availableQuantity = parseInt(select.options[select.selectedIndex].dataset.quantity);
                        const weightPerUnit = parseFloat(select.options[select.selectedIndex].dataset.weightPerUnit);
                        // Calculate desired pieces per box
                        const weightContribution = (percentage / 100) * boxWeight;
                        const pieces = Math.floor(weightContribution / weightPerUnit);
                        totalWeightUsed += pieces * weightPerUnit;
                        piecesDisplays[index].value = pieces > 0 ? pieces : '';
                        // Calculate max boxes based on available quantity
                        if (pieces > 0) {
                            const boxesForProduct = Math.floor(availableQuantity / pieces);
                            maxBoxes = Math.min(maxBoxes, boxesForProduct);
                        }
                    } else {
                        piecesDisplays[index].value = '';
                    }
                });

                // Validate total percentage equals 100%
                if (totalPercentage !== 100) {
                    productsError.textContent = 'Add more products or increase the product percentage to reach 100%.';
                    calculatedBoxesInput.value = '0 boxes';
                    piecesDisplays.forEach(display => display.value = '');
                    return;
                }

                // Validate at least one valid product
                if (!hasValidProduct) {
                    productsError.textContent = 'Please select at least one product with a valid percentage.';
                    calculatedBoxesInput.value = '0 boxes';
                    piecesDisplays.forEach(display => display.value = '');
                    return;
                }

                // Update calculated boxes
                calculatedBoxesInput.value = maxBoxes > 0 && isFinite(maxBoxes) ? `${maxBoxes} box${maxBoxes > 1 ? 'es' : ''}` : '0 boxes';
            }

            // Save box configuration
            saveBoxBtn.addEventListener('click', function() {
                const boxWeight = parseFloat(boxWeightInput.value) || 0;
                const boxName = boxNameInput.value.trim();
                const products = document.querySelectorAll('.product-select');
                const percentages = document.querySelectorAll('.percentage-input');
                const piecesDisplays = document.querySelectorAll('.pieces-display');
                const boxId = boxIdInput.value;

                // Validate box name
                if (!boxName) {
                    nameError.textContent = 'Box name is required.';
                    return;
                }

                // Validate box weight and products
                if (boxWeight < 500) {
                    weightError.textContent = 'Box weight must be 500 grams or more.';
                    return;
                }

                let totalPercentage = 0;
                let hasValidProduct = false;
                let maxBoxes = Infinity;
                const productData = [];

                products.forEach((select, index) => {
                    const percentage = parseFloat(percentages[index].value) || 0;
                    totalPercentage += percentage;

                    if (select.value && percentage > 0) {
                        hasValidProduct = true;
                        const productId = select.value;
                        const weightPerUnit = parseFloat(select.options[select.selectedIndex].dataset.weightPerUnit);
                        const pieces = Math.floor((percentage / 100) * boxWeight / weightPerUnit);
                        if (pieces > 0) {
                            productData.push({
                                product_id: productId,
                                percentage: percentage,
                                pieces: pieces
                            });
                            const availableQuantity = parseInt(select.options[select.selectedIndex].dataset.quantity);
                            const boxesForProduct = Math.floor(availableQuantity / pieces);
                            maxBoxes = Math.min(maxBoxes, boxesForProduct);
                        }
                    }
                });

                if (totalPercentage !== 100) {
                    productsError.textContent = 'Add more products or increase the product percentage to reach 100%.';
                    return;
                }

                if (!hasValidProduct) {
                    productsError.textContent = 'Please select at least one product with a valid percentage.';
                    return;
                }

                // Prepare data for saving
                const data = {
                    box_id: boxId || null,
                    box_name: boxName,
                    box_weight: boxWeight,
                    max_boxes: maxBoxes,
                    products: productData,
                    _token: document.querySelector('input[name="_token"]').value
                };

                // Send AJAX request to save or update
                fetch('{{ route("admins.box.save") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': data._token
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Box saved successfully!');
                        // Reset form for new entry
                        boxIdInput.value = '';
                        boxNameInput.value = '';
                        boxWeightInput.value = '1000';
                        productList.innerHTML = productList.children[0].outerHTML;
                        updateBoxCalculation();
                    } else {
                        alert('Error saving box: ' + result.message);
                    }
                })
                .catch(error => {
                    alert('Error saving box: ' + error.message);
                });
            });

            // Initial calculation
            updateBoxCalculation();
        });
    </script>

@endsection