@extends('admins.master')

@section('shipping_active_c1', 'active')
@section('countries', 'active')

@section('title', 'Countries')

@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Country List</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('admins.countries.create') }}" class="btn btn-primary btn-xs">Add Country</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Creation Ago</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr = 1; @endphp
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $country->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($country->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <div class="switch">
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" name="country_status"
                                                            data-id="{{ $country->id }}"
                                                            {{ $country->status == 1 ? 'checked' : '' }}
                                                            class="onoffswitch-checkbox" id="country-{{ $country->id }}">
                                                        <label class="onoffswitch-label" for="country-{{ $country->id }}">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('admins.countries.edit', $country->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.countries.delete_get', $country->id) }}"
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
                var country_id = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
                updateStatus(status, country_id);
            });

            function updateStatus(status, country_id) {
                if (country_id > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        url: "{{ route('admins.countries.toggle-status') }}",
                        type: "POST",
                        data: {
                            country_id: country_id,
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
