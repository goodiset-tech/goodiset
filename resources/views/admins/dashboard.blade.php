@extends('admins.master')

@section('dashboard_active', 'active')

@section('title', 'Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="{{ url('/admin/dashboard') }}">
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

                    <div id="customDateRange"
                        style="display: {{ $dateFilter == 'custom' ? 'block' : 'none' }}; margin-top: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="from_date">From:</label>
                                <input type="date" name="from_date" id="from_date" class="form-control"
                                    value="{{ $fromDate ?? ($dateFilter == 'custom' ? \Carbon\Carbon::now()->subDays(15)->toDateString() : '') }}"
                                    onchange="this.form.submit()">
                            </div>
                            <div class="col-md-6">
                                <label for="to_date">To:</label>
                                <input type="date" name="to_date" id="to_date" class="form-control"
                                    value="{{ $toDate ?? ($dateFilter == 'custom' ? \Carbon\Carbon::now()->toDateString() : '') }}"
                                    onchange="this.form.submit()">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div></br>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Order Count Graph</h5>
                    </div>
                    <div class="ibox-content">
                        <canvas id="orderCountChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Order Value Graph</h5>
                    </div>
                    <div class="ibox-content">
                        <canvas id="orderValueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><a href="category">Categories</a></h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a href="{{ url('/') }}/admin/category">{{ count($categories) }}</a>
                        </h1>
                        <small>Total Categories</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><a href="product_form">Products</a></h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a href="{{ url('/') }}/admin/products">{{ count($products) }}</a>
                        </h1>
                        <small>Total Products</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><a href="review">Reviews</a></h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a href="{{ url('/') }}/admin/approve_review">{{ count($rating) }}</a>
                        </h1>
                        <small>Total Reviews</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pending Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a href="{{ url('/') }}/admin/orders">{{ count($pending_orders) }}</a>
                        </h1>
                        <small>Total New Orders</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Complete Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a
                                href="{{ url('/') }}/admin/deliverd_orders">{{ count($com_orders) }}</a></h1>
                        <small>Total Complete Orders</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Dispatched Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a
                                href="{{ url('/') }}/admin/dispatched_orders">{{ count($des_orders) }}</a></h1>
                        <small>Total Dispatched Orders</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Delivered Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a
                                href="{{ url('/') }}/admin/deliverd_orders">{{ count($del_orders) }}</a></h1>
                        <small>Total Delivered Orders</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Canceled Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><a
                                href="{{ url('/') }}/admin/canceled_orders">{{ count($can_orders) }}</a></h1>
                        <small>Total Canceled Orders</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Delivered Orders Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>:
                            {{ number_format($deliverd_orders_amount, 2) }}
                        </h1>
                        <small>Delivered Orders Amount</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pending Orders Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>:
                            {{ number_format($pending_orders_amount, 2) }}
                        </h1>
                        <small>Pending Orders Amount</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Dispatched Orders Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>:
                            {{ number_format($dispatch_orders_amount, 2) }}
                        </h1>
                        <small>Dispatched Orders Amount</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Confirmed Orders Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>:
                            {{ number_format($confirmed_orders_amount, 2) }}
                        </h1>
                        <small>Confirmed Orders Amount</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Canceled Orders Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>:
                            {{ number_format($canceled_orders_amount, 2) }}
                        </h1>
                        <small>Canceled Orders Amount</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Visitors</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $totalVisitors }}</h1>
                        <small>Total Visitors ({{ ucfirst(str_replace('_', ' ', $dateFilter)) }})</small>
                    </div>
                </div>
            </div>
            <!-- Net Order Amount Card -->
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Net Order Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>:
                            {{ number_format($net_order_amount, 2) }}
                        </h1>
                        <small>Net Order Amount (After Adjustments)</small>
                    </div>
                </div>
            </div>
            <!-- VAT Card -->
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>VAT</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>: {{ number_format($total_vat, 2) }}</h1>
                        <small>Total VAT</small>
                    </div>
                </div>
            </div>
            <!-- Discount Card -->
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Discount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>: {{ number_format($total_discount, 2) }}
                        </h1>
                        <small>Total Discount</small>
                    </div>
                </div>
            </div>
            <!-- Shipping Card -->
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Shipping</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><span class="icon-aed">{{ getSetting('currency') }}</span>: {{ number_format($total_shipping, 2) }}
                        </h1>
                        <small>Total Shipping Cost</small>
                    </div>
                </div>
            </div>

            {{-- <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Visitor Graph</h5>
                    </div>
                    <div class="ibox-content">
                        <canvas id="visitorChart" height="100"></canvas>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
    <script>
        // Visitor Chart
        // const visitorCtx = document.getElementById('visitorChart').getContext('2d');
        // const visitorChart = new Chart(visitorCtx, {
        //     type: 'line',
        //     data: {
        //         labels: @json($visitorDates),
        //         datasets: [{
        //             label: 'Visitors',
        //             data: @json($visitorCounts),
        //             backgroundColor: 'rgba(54, 162, 235, 0.2)',
        //             borderColor: 'rgba(54, 162, 235, 1)',
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        // Order Count Chart
        const orderCountCtx = document.getElementById('orderCountChart')?.getContext('2d');
        if (orderCountCtx) {
            const orderCountChart = new Chart(orderCountCtx, {
                type: 'line',
                data: {
                    labels: @json($orderDates),
                    datasets: [{
                            label: 'Pending Orders',
                            data: @json($pendingOrderCounts),
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Confirmed Orders',
                            data: @json($confirmedOrderCounts),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Dispatched Orders',
                            data: @json($dispatchedOrderCounts),
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Delivered Orders',
                            data: @json($deliveredOrderCounts),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Canceled Orders',
                            data: @json($canceledOrderCounts),
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Order Value Chart with Dynamic Currency
        const orderValueCtx = document.getElementById('orderValueChart')?.getContext('2d');
        if (orderValueCtx) {
            const orderValueChart = new Chart(orderValueCtx, {
                type: 'line',
                data: {
                    labels: @json($orderDates),
                    datasets: [{
                            label: 'Pending Order Value',
                            data: @json($pendingOrderValues),
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Confirmed Order Value',
                            data: @json($confirmedOrderValues),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Dispatched Order Value',
                            data: @json($dispatchedOrderValues),
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Delivered Order Value',
                            data: @json($deliveredOrderValues),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Canceled Order Value',
                            data: @json($canceledOrderValues),
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Value ({{ getSetting('currency') }})'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    let value = context.parsed.y;
                                    return label + '{{ getSetting('currency') }}' + value.toFixed(2);
                                }
                            }
                        }
                    }
                }
            });
        }

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
@endsection
