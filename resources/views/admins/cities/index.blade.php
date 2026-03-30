@extends('admins.master')

@section('shipping_active_c1', 'active')
@section('cities', 'active')
@section('title', 'Cities')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>City List</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('admins.cities.create') }}" class="btn btn-primary btn-xs">Add City</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Creation Ago</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr = 1; @endphp
                                    @foreach ($cities as $city)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $city->name }}</td>
                                            <td>{{ $city->country->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($city->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <div class="switch">
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" name="city_status"
                                                            data-id="{{ $city->id }}"
                                                            {{ $city->status == 1 ? 'checked' : '' }}
                                                            class="onoffswitch-checkbox" id="city-{{ $city->id }}">
                                                        <label class="onoffswitch-label" for="city-{{ $city->id }}">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('admins.cities.edit', $city->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.cities.delete_get', $city->id) }}"
                                                    class="btn btn-danger delete_record">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
            $(document).on('change', '.onoffswitch-checkbox', function() {
                var city_id = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
                updateStatus(status, city_id);
            });

            function updateStatus(status, city_id) {
                if (city_id > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        url: "{{ route('admins.cities.toggle-status') }}",
                        type: "POST",
                        data: {
                            city_id: city_id,
                            Status: status,
                        },
                        success: function(response) {
                            showToastr(response.msg, response.msg_type);
                        }
                    });
                }
            }
        });
    </script>
@endpush
