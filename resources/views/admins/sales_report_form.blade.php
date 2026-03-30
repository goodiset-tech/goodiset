<style>
    td {
        vertical-align: middle !important;
    }

    td img {
        width: 50px;
    }
</style>
@extends('admins.master')

@section('title', 'Sales Repots')
@section('sales', 'active')
<?php
use App\Models\Admins\Product;
?>

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Sales Report</h5>
                    </div>
                    <div class="ibox-content">
                        {{-- <div class="row">
                            <div class="col-md-4">
                                <label for="categories">Select Categories:</label>
                                <select id="categories" class="form-control js-example-basic-multiple" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="products">Select Products:</label>
                                <select id="products" class="form-control js-example-basic-multiple" multiple>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">

                                <button class="btn btn-primary" onclick="fetchSalesReport()">Get Report</button>
                            </div>
                        </div> --}}

                        <div id="report"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchSalesReport(); // Load all sales on page load
        });
        function fetchSalesReport() {
            let query = '/admin/sales-report';
            fetch(query)
                .then(response => response.json())
                .then(data => displayReport(data))
                .catch(error => console.error('Error fetching report:', error));
        }

        function displayReport(data) {
            let reportHTML = '';

            for (const categoryId in data) {
                const category = data[categoryId];
                reportHTML += `<h3>${category.category_name}</h3>`;
                reportHTML += `<p><strong>Total Sales:</strong> <span class="icon-aed">{{getSetting('currency')}}</span>${category.total_sales}</p>`;
                reportHTML += `<p><strong>Total Quantity Sold:</strong> ${category.total_quantity}</p>`;
                reportHTML += '<table border="1" id="productTable" class="table table-striped table-bordered table-hover"><tr><th>Product Name</th><th>Total Sales</th><th>Total Quantity</th></tr>';

                for (const productId in category.products) {
                    const product = category.products[productId];
                    reportHTML +=
                        `<tr><td>${product.name}</td><td><span class="icon-aed">{{getSetting('currency')}}</span>${product.total_sales}</td><td>${product.total_quantity}</td></tr>`;
                }

                reportHTML += '</table>';
            }

            document.getElementById('report').innerHTML = reportHTML;
        }
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            var table = $('#productTable').DataTable();
        });
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
