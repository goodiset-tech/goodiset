@extends('admins.master')

@section('visits_active', 'active')

@section('title', 'Visits')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="wrapper wrapper-content">
        <!-- Date Filter -->
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="{{ url('/admin/visits') }}">
                    <label for="date_filter">Filter by Date:</label>
                    <select name="date_filter" class="form-control" id="date_filter" onchange="this.form.submit()">
                        <option value="last_7_days" {{ $dateFilter == 'last_7_days' ? 'selected' : '' }}>Last 7 Days
                        </option>
                        <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ $dateFilter == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="this_week" {{ $dateFilter == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="last_week" {{ $dateFilter == 'last_week' ? 'selected' : '' }}>Last Week</option>
                        <option value="this_month" {{ $dateFilter == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ $dateFilter == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="this_year" {{ $dateFilter == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="last_year" {{ $dateFilter == 'last_year' ? 'selected' : '' }}>Last Year</option>
                        <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>Since Launch</option>
                    </select>
                </form>
            </div>
        </div></br>

        <!-- Visitor Statistics -->
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Total Visitors</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $totalVisitors }}</h1>
                        <small>Total Visitors ({{ ucfirst(str_replace('_', ' ', $dateFilter)) }})</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Unique Countries</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $uniqueCountries }}</h1>
                        <small>Unique Countries</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visits by Day (Chart) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Visits by Day</h5>
                    </div>
                    <div class="ibox-content">
                        <canvas id="visitsByDayChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visits by Country (Chart) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Visits by Country</h5>
                    </div>
                    <div class="ibox-content">
                        <canvas id="visitsByCountryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visits by GCC Country (Chart) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Visits by GCC Country</h5>
                    </div>
                    <div class="ibox-content">
                        <canvas id="visitsByGCCChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitor Map -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Visitor Map</h5>
                    </div>
                    <div class="ibox-content">
                        <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxAXN3Cq2SNng0QH5hiG8qRbGgvosUig0"></script>
    <script>
        // Visits by Day Chart
        const visitsByDayData = @json($visitsByDay);
        const dayLabels = visitsByDayData.map(item => item.visit_date);
        const dayData = visitsByDayData.map(item => item.total_visitors);

        const ctxDay = document.getElementById('visitsByDayChart').getContext('2d');
        new Chart(ctxDay, {
            type: 'line',
            data: {
                labels: dayLabels,
                datasets: [{
                    label: 'Visitors',
                    data: dayData,
                    backgroundColor: 'rgba(26, 179, 148, 0.2)',
                    borderColor: 'rgba(26, 179, 148, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Visits by Country Chart
        const visitsByCountryData = @json($visitsByCountry);
        const countryLabels = visitsByCountryData.map(item => item.country);
        const countryData = visitsByCountryData.map(item => item.total_visitors);

        const ctx = document.getElementById('visitsByCountryChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: countryLabels,
                datasets: [{
                    label: 'Visitors',
                    data: countryData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Visits by GCC Country Chart
        const gccData = @json($gccData);
        const gccLabels = gccData.map(item => item.country);
        const gccValues = gccData.map(item => item.total_visitors);

        const ctxGCC = document.getElementById('visitsByGCCChart').getContext('2d');
        new Chart(ctxGCC, {
            type: 'bar',
            data: {
                labels: gccLabels,
                datasets: [{
                    label: 'Visitors',
                    data: gccValues,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Visitor Map
        const mapData = @json($mapData);

        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 2,
                center: {
                    lat: 0,
                    lng: 0
                }
            });

            mapData.forEach(item => {
                fetch(
                        `https://maps.googleapis.com/maps/api/geocode/json?address=${item.country}&key=AIzaSyDxAXN3Cq2SNng0QH5hiG8qRbGgvosUig0`
                    )
                    .then(response => response.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            const location = data.results[0].geometry.location;
                            new google.maps.Marker({
                                position: location,
                                map: map,
                                title: `${item.country}: ${item.visitors} visitors`
                            });
                        }
                    });
            });
        }

        initMap();
    </script>
@endsection
