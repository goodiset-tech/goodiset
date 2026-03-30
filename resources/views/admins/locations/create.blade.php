@extends('admins.master')

@section('locations_active', 'active')

@section('title', 'Create Location')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create New Location</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('admins.locations.store') }}" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="google_place_id" id="google_place_id" value="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Type</label>
                                <div class="col-sm-10">
                                    <input type="text" name="type" class="form-control">
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" id="address" class="form-control">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Location Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="location_name" id="location_name" class="form-control"
                                        readonly>
                                    @error('location_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Latitude</label>
                                <div class="col-sm-10">
                                    <input type="text" name="latitude" id="latitude" class="form-control" readonly>
                                    @error('latitude')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Longitude</label>
                                <div class="col-sm-10">
                                    <input type="text" name="longitude" id="longitude" class="form-control" readonly>
                                    @error('longitude')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contact Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="contact_name" class="form-control">
                                    @error('contact_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contact Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="contact_email" class="form-control">
                                    @error('contact_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contact Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" name="contact_phone" class="form-control">
                                    @error('contact_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Open/Close Time</label>
                                <div class="col-sm-10">
                                    <input type="text" name="open_close_time" class="form-control"
                                        placeholder="e.g., 09:00-17:00">
                                    @error('open_close_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('admins.locations.index') }}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxAXN3Cq2SNng0QH5hiG8qRbGgvosUig0&libraries=places">
    </script>
    <script>
        function initMap() {
            const input = document.getElementById('address');

            const autocomplete = new google.maps.places.Autocomplete(input, {
                fields: ['place_id', 'geometry', 'name', 'formatted_address'],
            });

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();

                if (!place.place_id || !place.geometry) {
                    alert('Please select a valid location from suggestions.');
                    return;
                }

                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
                document.getElementById('location_name').value = place.name;
                document.getElementById('google_place_id').value = place.place_id;
            });
        }
        window.onload = initMap;
    </script>
@endsection
