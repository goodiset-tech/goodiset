@extends('admins.master')

@section('title', 'General Ledger Report')
@section('ledger_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="{{ route('admins.general-ledger') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="date_filter">Filter by Date:</label>
                            <select name="date_filter" class="form-control" id="date_filter"
                                onchange="toggleDateInputs(this); this.form.submit()">
                                <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="yesterday" {{ $dateFilter == 'yesterday' ? 'selected' : '' }}>Yesterday
                                </option>
                                <option value="this_week" {{ $dateFilter == 'this_week' ? 'selected' : '' }}>This Week
                                </option>
                                <option value="last_week" {{ $dateFilter == 'last_week' ? 'selected' : '' }}>Last Week
                                </option>
                                <option value="this_month" {{ $dateFilter == 'this_month' ? 'selected' : '' }}>This Month
                                </option>
                                <option value="last_month" {{ $dateFilter == 'last_month' ? 'selected' : '' }}>Last Month
                                </option>
                                <option value="this_year" {{ $dateFilter == 'this_year' ? 'selected' : '' }}>This Year
                                </option>
                                <option value="last_year" {{ $dateFilter == 'last_year' ? 'selected' : '' }}>Last Year
                                </option>
                                <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="custom" {{ $dateFilter == 'custom' ? 'selected' : '' }}>Custom Date Range
                                </option>
                            </select>


                        </div>
                        <div class="col-md-6">
                            <label for="status_filter">Filter by Status:</label>
                            <select name="status_filter" class="form-control" id="status_filter"
                                onchange="this.form.submit()">
                                <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Transactions
                                </option>
                                <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $statusFilter == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="dispatched" {{ $statusFilter == 'dispatched' ? 'selected' : '' }}>Dispatched
                                </option>
                                <option value="delivered" {{ $statusFilter == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="canceled" {{ $statusFilter == 'canceled' ? 'selected' : '' }}>Canceled
                                </option>
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
                        <h5>General Ledger Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="generalLedgerTable" class="display table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order No</th>
                                        <th>Customer</th>
                                        <th>Type</th>
                                        <th>Shipping Method</th>
                                        <th>Payment Method</th>
                                        <th>Vat (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Discount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Shipping (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Amount (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                                        <th>Payment Status</th>
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
            $('#generalLedgerTable').DataTable({
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
                    url: '{{ url('/admin/api/general-ledger-report') }}',
                    data: function(d) {
                        d.date_filter = $('#date_filter').val();
                        d.status_filter = $('#status_filter').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'order_no',
                        name: 'order_no'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'shipping_method',
                        name: 'shipping_method'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'vat',
                        name: 'vat'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'shipping',
                        name: 'shipping'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
