@extends('admins.master')

@section('title', 'Monthly Odoo Report')
@section('sales_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Monthly Odoo Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="monthlyOdooTable" class="display table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Month</th>
                                        <th>Item Total without Discount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Total Invoice (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Total Invoice After Discount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Total Collected (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>VAT on Invoice (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>VAT on Items (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th> <!-- New Column -->
                                        <th>Discount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Shipping (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
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
                                        <th></th> <!-- New Footer Column -->
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
            $('#monthlyOdooTable').DataTable({
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
                    url: '{{ url('/admin/api/monthly-odoo-report') }}',
                },
                columns: [
                    { data: 'sr_no', name: 'sr_no', searchable: false, orderable: true },
                    { data: 'month', name: 'month', orderable: true },
                    { data: 'item_total_without_discount', name: 'item_total_without_discount', orderable: true },
                    { data: 'total_amount', name: 'total_amount', orderable: true },
                    { data: 'total_amount_after_discount', name: 'total_amount_after_discount', orderable: true },
                    { data: 'total_collected', name: 'total_collected', orderable: true },
                    { data: 'total_vat', name: 'total_vat', orderable: true },
                    { data: 'vat_on_items', name: 'vat_on_items', orderable: true }, // New Column
                    { data: 'total_discount', name: 'total_discount', orderable: true },
                    { data: 'total_shipping', name: 'total_shipping', orderable: true }
                ],
                order: [[0, 'asc']],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();

                    // Check if json and grandTotals exist
                    if (json && json.grandTotals) {
                        var grandTotals = json.grandTotals;

                        // Update footer with grand totals
                        $(api.column(2).footer()).html(grandTotals.item_total_without_discount || '0.00');
                        $(api.column(3).footer()).html(grandTotals.total_amount || '0.00');
                        $(api.column(4).footer()).html(grandTotals.total_amount_after_discount || '0.00');
                        $(api.column(5).footer()).html(grandTotals.total_collected || '0.00');
                        $(api.column(6).footer()).html(grandTotals.total_vat || '0.00');
                        $(api.column(7).footer()).html(grandTotals.vat_on_items || '0.00'); // New Footer Column
                        $(api.column(8).footer()).html(grandTotals.total_discount || '0.00');
                        $(api.column(9).footer()).html(grandTotals.total_shipping || '0.00');
                    } else {
                        // Set default values if grandTotals is not available
                        $(api.column(2).footer()).html('0.00');
                        $(api.column(3).footer()).html('0.00');
                        $(api.column(4).footer()).html('0.00');
                        $(api.column(5).footer()).html('0.00');
                        $(api.column(6).footer()).html('0.00');
                        $(api.column(7).footer()).html('0.00'); // New Footer Column
                        $(api.column(8).footer()).html('0.00');
                        $(api.column(9).footer()).html('0.00');
                    }
                }
            });
        });
    </script>
@endpush