<!DOCTYPE html>
<html>
<head>
    <title>Driver Order Update - Order #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
            margin-top: 50px;
        }
        #map {
            height: 400px;
            width: 100%;
            margin-bottom: 20px;
        }
        .order-details {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order #{{ $order->id }} Status Update</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('driver.order.update', $order->driver_token) }}">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Delivery Status</label>
                        <select class="form-control" name="dstatus">
                            <option value="0" {{ $order->dstatus == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $order->dstatus == 1 ? 'selected' : '' }}>Confirmed</option>
                            <option value="2" {{ $order->dstatus == 2 ? 'selected' : '' }}>Delivered</option>
                            <option value="3" {{ $order->dstatus == 3 ? 'selected' : '' }}>Cancel</option>
                            <option value="4" {{ $order->dstatus == 4 ? 'selected' : '' }}>Dispatched</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
                <div class="col-md-8">
                    <div class="order-details">
                        <h4>Customer Details</h4>
                        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
                        <p><strong>Note:</strong> {{ $order->note ?? 'N/A' }}</p>
                        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Dubai') }}</p>
                        <p><strong>Shipping Company:</strong> {{ $order->shipping_company ?? 'N/A' }}</p>
                        <p><strong>Tracking No:</strong> {{ $order->track_no ?? 'N/A' }}</p>
                        @if($order->track_url)
                            <p><strong>Tracking URL:</strong> <a href="{{ $order->track_url }}" target="_blank">{{ $order->track_url }}</a></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="row">
                <div class="col-12">
                    <h4>Delivery Location</h4>
                    <div id="map"></div>
                </div>
            </div>

            <!-- Order Items Table -->
            <div class="row">
                <div class="col-12">
                    <h4>Order Items</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pro = json_decode($order->product_detail);
                                foreach ($pro as $v) {
                                    if ($v->id != null) {
                                        $product = \App\Models\Admins\Product::where(['id' => $v->id])->first();
                                        if ($product) {
                            @endphp
                            <tr>
                                <td>{{ $product->product_name ?? '' }}</td>
                                <td>{{ $v->qty }}</td>
                                @if (isset($v->name) && $v->name == 'Free Product')
                                    <td>{{ $v->name }}</td>
                                @else
                                    <td>{{ getSetting('currency') }}:{{ optional($v)->price ? $v->qty * $v->price : $product->discount_price }}</td>
                                @endif
                            </tr>
                            @php
                                    }
                                }}
                            @endphp

                            @php
                                $pack = json_decode($order->package_detail);
                                foreach ($pack as $value) {
                                    $package = \App\Models\BoxCustomize::where('package_id', $value->package_type)
                                        ->where('size_id', $value->package_size)
                                        ->first();
                                    if($package){
                                        $box_size = \App\Models\BoxSize::where('id',$value->package_size)->first();
                                        $PackageType = \App\Models\PackageType::where('id',$value->package_type)->first();
                            @endphp
                            <tr>
                                <td>{{ $PackageType->name }} <span>({{ $box_size->name }})</span></td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ getSetting('currency') }}:{{ $value->qty * $value->package_price }}</td>
                            </tr>
                            @php
                                    }
                                }
                            @endphp
                        </tbody>
                        <tfoot>
                            @if ($order->shipping_fee)
                                <tr>
                                    <td></td>
                                    <th>Shipping</th>
                                    <td>{{ getSetting('currency') }}:{{ $order->shipping_fee }}</td>
                                </tr>
                            @endif
                            @if ($order->vat)
                                <tr>
                                    <td></td>
                                    <th>Vat</th>
                                    <td>{{ getSetting('currency') }}:{{ $order->vat }}</td>
                                </tr>
                            @endif
                            @if ($order->discount)
                                <tr>
                                    <td></td>
                                    <th>Discount</th>
                                    <td>{{ getSetting('currency') }}:{{ $order->discount }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <th>Totals</th>
                                <td>{{ getSetting('currency') }}:{{ $order->amount }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxAXN3Cq2SNng0QH5hiG8qRbGgvosUig0&libraries=places"></script>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: { lat: 25.2187726, lng: 55.3637911 } // Default center (Dubai)
            });

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: false // Show markers at start and end
            });

            const pickupLocation = "Dubai Festival City, Dubai, United Arab Emirates";
            const dropoffLocation = "{{ $order->address }}, {{ $order->city }}, {{ $order->country }}";

            // Request directions
            directionsService.route({
                origin: pickupLocation,
                destination: dropoffLocation,
                travelMode: google.maps.TravelMode.DRIVING
            }, function(response, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);

                    // Extract and display distance and duration
                    const route = response.routes[0].legs[0];
                    const distance = route.distance.text;
                    const duration = route.duration.text;

                    // Add info below map
                    const infoDiv = document.createElement('div');
                    infoDiv.className = 'mt-2';
                    infoDiv.innerHTML = `
                        <p><strong>Distance:</strong> ${distance}</p>
                        <p><strong>Estimated Duration:</strong> ${duration}</p>
                    `;
                    
                    // Add directions button
                    const directionsButton = document.createElement('button');
                    directionsButton.type = 'button';
                    directionsButton.className = 'btn btn-primary mt-2';
                    directionsButton.textContent = 'Open in Google Maps';
                    directionsButton.onclick = function() {
                        window.open(`https://www.google.com/maps/dir/?api=1&origin=${encodeURIComponent(pickupLocation)}&destination=${encodeURIComponent(dropoffLocation)}&travelmode=driving`, '_blank');
                    };

                    // Append elements after map
                    const mapElement = document.getElementById('map');
                    mapElement.parentNode.insertBefore(infoDiv, mapElement.nextSibling);
                    mapElement.parentNode.insertBefore(directionsButton, infoDiv.nextSibling);
                } else {
                    console.error('Directions request failed: ' + status);
                    
                    // Fallback to showing just the destination if directions fail
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ 'address': dropoffLocation }, function(results, status) {
                        if (status === 'OK') {
                            map.setCenter(results[0].geometry.location);
                            new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location
                            });
                        } else {
                            console.error('Geocode was not successful: ' + status);
                        }
                    });
                }
            });
        }

        // Initialize map when page loads
        window.onload = initMap;
    </script>
</body>
</html>
