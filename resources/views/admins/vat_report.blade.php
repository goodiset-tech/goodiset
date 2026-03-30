@extends('admins.master')

@section('title', 'VAT Report')
@section('vat_report', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="{{ route('admins.vat-report-view') }}">
                    <div class="row">
                        <div class="col-md-6">
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
                                <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="custom" {{ $dateFilter == 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status_filter">Filter by Status:</label>
                            <select name="status_filter" class="form-control" id="status_filter"
                                    onchange="this.form.submit()">
                                <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Transactions</option>
                                <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $statusFilter == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="dispatched" {{ $statusFilter == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                <option value="delivered" {{ $statusFilter == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $statusFilter == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                        <!-- Custom Date Range Inputs -->
                        <div id="customDateRange"
                            style="display: {{ $dateFilter == 'custom' ? 'block' : 'none' }}; margin-top: 10px;">
                            <div class="col-md-6">
                                <label for="from_date">From:</label>
                                <input type="date" name="from_date" id="from_date" class="form-control"
                                    value="{{ $fromDate ?? '' }}" onchange="this.form.submit()">
                            </div>
                            <div class="col-md-6">
                                <label for="to_date">To:</label>
                                <input type="date" name="to_date" id="to_date" class="form-control"
                                    value="{{ $toDate ?? '' }}" onchange="this.form.submit()">
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
                        <h5>VAT Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="vatReportTable" class="display table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Invoice Total (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>VAT Amount (5%) (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Shipping Amount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Discount Amount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Amount Excl. VAT (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                    </tr>
                                </thead>
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
            $('#vatReportTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
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
                    url: '{{ route('admins.vat-report') }}',
                    data: function(d) {
                        d.date_filter = $('#date_filter').val();
                        d.status_filter = $('#status_filter').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [
                    { data: 'invoice_no', name: 'invoice_no' },
                    { data: 'invoice_total', name: 'invoice_total' },
                    { data: 'vat_amount', name: 'vat_amount' },
                    { data: 'shipping_amount', name: 'shipping_amount' },
                    { data: 'discount_amount', name: 'discount_amount' },
                    { data: 'amount_excluding_vat', name: 'amount_excluding_vat' }
                ]
            });
        });

        function toggleDateInputs(select) {
            const customDateRange = document.getElementById('customDateRange');
            const fromDateInput = document.getElementById('from_date');
            const toDateInput = document.getElementById('to_date');

            if (select.value === 'custom') {
                customDateRange.style.display = 'block';
                
                // Only set default dates if the fields are empty
                if (!fromDateInput.value && !toDateInput.value) {
                    // Set "To" date to today
                    const today = new Date();
                    toDateInput.value = today.toISOString().split('T')[0];

                    // Set "From" date to one month ago
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
@endpush