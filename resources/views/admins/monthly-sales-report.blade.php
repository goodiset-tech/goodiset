@extends('admins.master')

@section('title', 'Monthly Sales Report')
@section('sales_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Monthly Sales Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="monthlySalesTable" class="display table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Month</th>
                                        <th>No. of Orders</th>
                                        <th>Total Amount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>VAT (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Discount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Shipping (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Stripe (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Apple Pay (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Google Pay (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Cash on Delivery (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Express Checkout (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Grand Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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
            $('#monthlySalesTable').DataTable({
                processing: true,
                serverSide: false,
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
                        className: 'btn btn-sm',
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
                    url: '{{ url('/admin/api/monthly-sales-report') }}',
                },
                columns: [
                    { data: 'sr_no', name: 'sr_no', searchable: false, orderable: true },
                    { data: 'month', name: 'month', orderable: true },
                    { data: 'order_count', name: 'order_count', orderable: true },
                    { data: 'total_amount', name: 'total_amount', orderable: true },
                    { data: 'total_vat', name: 'total_vat', orderable: true },
                    { data: 'total_discount', name: 'total_discount', orderable: true },
                    { data: 'total_shipping', name: 'total_shipping', orderable: true },
                    { data: 'stripe_amount', name: 'stripe_amount', orderable: true },
                    { data: 'apple_pay_amount', name: 'apple_pay_amount', orderable: true },
                    { data: 'google_pay_amount', name: 'google_pay_amount', orderable: true },
                    { data: 'cod_amount', name: 'cod_amount', orderable: true },
                    { data: 'express_checkout_amount', name: 'express_checkout_amount', orderable: true }
                ],
                order: [[0, 'asc']],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();

                    // Check if json and grandTotals exist
                    if (json && json.grandTotals) {
                        var grandTotals = json.grandTotals;

                        // Update footer with grand totals
                        $(api.column(2).footer()).html(grandTotals.order_count || '0');
                        $(api.column(3).footer()).html(grandTotals.total_amount || '0.00');
                        $(api.column(4).footer()).html(grandTotals.total_vat || '0.00');
                        $(api.column(5).footer()).html(grandTotals.total_discount || '0.00');
                        $(api.column(6).footer()).html(grandTotals.total_shipping || '0.00');
                        $(api.column(7).footer()).html(grandTotals.stripe_amount || '0.00');
                        $(api.column(8).footer()).html(grandTotals.apple_pay_amount || '0.00');
                        $(api.column(9).footer()).html(grandTotals.google_pay_amount || '0.00');
                        $(api.column(10).footer()).html(grandTotals.cod_amount || '0.00');
                        $(api.column(11).footer()).html(grandTotals.express_checkout_amount || '0.00');
                    } else {
                        // Set default values if grandTotals is not available
                        $(api.column(2).footer()).html('0');
                        $(api.column(3).footer()).html('0.00');
                        $(api.column(4).footer()).html('0.00');
                        $(api.column(5).footer()).html('0.00');
                        $(api.column(6).footer()).html('0.00');
                        $(api.column(7).footer()).html('0.00');
                        $(api.column(8).footer()).html('0.00');
                        $(api.column(9).footer()).html('0.00');
                        $(api.column(10).footer()).html('0.00');
                        $(api.column(11).footer()).html('0.00');
                    }
                }
            });
        });
    </script>
@endpush