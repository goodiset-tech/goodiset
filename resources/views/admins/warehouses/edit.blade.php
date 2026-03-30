@extends('admins.master')

@section('warehouse_active', 'active')

@section('title', 'Edit Warehouse')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit Warehouse</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admins.warehouses.update', $warehouse->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $warehouse->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="pickup" {{ $warehouse->type == 'pickup' ? 'selected' : '' }}>Pickup</option>
                                    <option value="dropoff" {{ $warehouse->type == 'dropoff' ? 'selected' : '' }}>Dropoff</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="location_name">Location Name</label>
                                <input type="text" name="location_name" id="location_name" class="form-control" value="{{ $warehouse->location_name }}">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ $warehouse->address }}" required>
                                <input type="hidden" name="latitude" id="latitude" value="{{ $warehouse->latitude }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ $warehouse->longitude }}">
                            </div>
                            <div class="form-group">
                                <label for="contact_name">Contact Name</label>
                                <input type="text" name="contact_name" id="contact_name" class="form-control" value="{{ $warehouse->contact_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_email">Contact Email</label>
                                <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ $warehouse->contact_email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_phone">Contact Phone</label>
                                <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ $warehouse->contact_phone }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Warehouse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxAXN3Cq2SNng0QH5hiG8qRbGgvosUig0&libraries=places"></script>
    <script>
        function initMap() {
            const input = document.getElementById('address');
            const autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function () {
                const place = autocomplete.getPlace();
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
                document.getElementById('location_name').value = place.name; // Populate location name
            });
        }
        initMap();
    </script>
@endsection