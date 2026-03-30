@extends('admins.master')

@section('title', 'Category Sales Reports')
@section('sales_active', 'active')
<?php
use App\Models\Admins\Product;
?>

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="{{ url('/admin/category-sales-report') }}">
                    <label for="date_filter">Filter by Date:</label>
                    <select name="date_filter" class="form-control" id="date_filter"
                            onchange="toggleDateInputs(this); this.form.submit()">
                        <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ $dateFilter == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="this_week" {{ $dateFilter == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="last_week" {{ $dateFilter == 'last_week' ? 'selected' : '' }}>Last Week</option>
                        <option value="this_month" {{ $dateFilter == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ $dateFilter == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="this_year" {{ $dateFilter == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="last_year" {{ $dateFilter == 'last_year' ? 'selected' : '' }}>Last Year</option>
                        <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>Since Launch</option>
                        <option value="custom" {{ $dateFilter == 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                    </select>

                    <!-- Custom Date Range Inputs -->
                    <div id="customDateRange"
                         style="display: {{ $dateFilter == 'custom' ? 'block' : 'none' }}; margin-top: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="from_date">From:</label>
                                <input type="date" name="from_date" id="from_date" class="form-control"
                                       value="{{ $fromDate ?? '' }}"
                                       onchange="this.form.submit()">
                            </div>
                            <div class="col-md-6">
                                <label for="to_date">To:</label>
                                <input type="date" name="to_date" id="to_date" class="form-control"
                                       value="{{ $toDate ?? '' }}"
                                       onchange="this.form.submit()">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Category Sales Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="categorySalesTable" class="display table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Total Sales ({{ getSetting('currency') }})</th>
                                        <th>Total Quantity Sold</th>
                                        <th>VAT 5% ({{ getSetting('currency') }})</th>
                                        <th>Avg Sale Price ({{ getSetting('currency') }})</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Grand Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Total Shipping</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Total Discount</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
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
            $('#categorySalesTable').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csv',
                        text: 'Export CSV',
                        className: 'btn btn-sm'
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        className: 'btn btn-sm custom-pdf-button',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-sm'
                    }
                ],
                ajax: {
                    url: '{{ url('/admin/api/category-sales-report') }}',
                    data: function(d) {
                        d.date_filter = $('#date_filter').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [
                    { data: 'category_name', name: 'category_name' },
                    { data: 'total_sales', name: 'total_sales' },
                    { data: 'total_quantity', name: 'total_quantity' },
                    { data: 'vat', name: 'vat' },
                    { data: 'avg_sale_price', name: 'avg_sale_price' }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();
                    console.log('Category Sales AJAX Response:', json);

                    try {
                        if (json && json.grandTotals) {
                            var grandTotals = json.grandTotals;
                            console.log('Grand Totals Applied:', grandTotals);

                            // Update grand total row
                            var grandTotalRow = $(api.table().footer()).find('tr').eq(0);
                            grandTotalRow.find('th').eq(0).html('Grand Total');
                            grandTotalRow.find('th').eq(1).html(grandTotals.total_sales || '0.00');
                            grandTotalRow.find('th').eq(2).html(grandTotals.total_quantity || '0');
                            grandTotalRow.find('th').eq(3).html(grandTotals.vat || '0.00');
                            grandTotalRow.find('th').eq(4).html('');

                            // Update total shipping row
                            var shippingRow = $(api.table().footer()).find('tr').eq(1);
                            shippingRow.find('th').eq(0).html('Total Shipping');
                            shippingRow.find('th').eq(1).html(grandTotals.total_shipping || '0.00');
                            shippingRow.find('th').eq(2).html('');
                            shippingRow.find('th').eq(3).html('');
                            shippingRow.find('th').eq(4).html('');

                            // Update total discount row
                            var discountRow = $(api.table().footer()).find('tr').eq(2);
                            discountRow.find('th').eq(0).html('Total Discount');
                            discountRow.find('th').eq(1).html(grandTotals.total_discount || '0.00');
                            discountRow.find('th').eq(2).html('');
                            discountRow.find('th').eq(3).html('');
                            discountRow.find('th').eq(4).html('');
                        } else {
                            console.warn('No grandTotals in response or invalid JSON');
                            // Fallback values
                            var grandTotalRow = $(api.table().footer()).find('tr').eq(0);
                            grandTotalRow.find('th').eq(0).html('Grand Total');
                            grandTotalRow.find('th').eq(1).html('0.00');
                            grandTotalRow.find('th').eq(2).html('0');
                            grandTotalRow.find('th').eq(3).html('0.00');
                            grandTotalRow.find('th').eq(4).html('');

                            var shippingRow = $(api.table().footer()).find('tr').eq(1);
                            shippingRow.find('th').eq(0).html('Total Shipping');
                            shippingRow.find('th').eq(1).html('0.00');
                            shippingRow.find('th').eq(2).html('');
                            shippingRow.find('th').eq(3).html('');
                            shippingRow.find('th').eq(4).html('');

                            var discountRow = $(api.table().footer()).find('tr').eq(2);
                            discountRow.find('th').eq(0).html('Total Discount');
                            discountRow.find('th').eq(1).html('0.00');
                            discountRow.find('th').eq(2).html('');
                            shippingRow.find('th').eq(3).html('');
                            shippingRow.find('th').eq(4).html('');
                        }
                    } catch (e) {
                        console.error('Error in footerCallback:', e);
                    }
                }
            });
        });

        function toggleDateInputs(select) {
            const customDateRange = document.getElementById('customDateRange');
            const fromDateInput = document.getElementById('from_date');
            const toDateInput = document.getElementById('to_date');

            if (select.value === 'custom') {
                customDateRange.style.display = 'block';
                
                if (!fromDateInput.value && !toDateInput.value) {
                    const today = new Date();
                    toDateInput.value = today.toISOString().split('T')[0];
                    const oneMonthAgo = new Date();
                    oneMonthAgo.setMonth(today.getMonth() - 1);
                    fromDateInput.value = oneMonthAgo.toISOString().split('T')[0];
                }
            } else {
                customDateRange.style.display = 'none';
                fromDateInput.value = '';
                toDateInput.value = '';
            }
        }
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush