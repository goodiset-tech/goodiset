@extends('admins.master')

@section('shipping_active_c1', 'active')
@section('shipping_zone', 'active')
@section('title', 'Shipping Zones')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Shipping Zone List</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('admins.shipping-zones.create') }}" class="btn btn-primary btn-xs">Add Shipping Zone</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Countries</th>
                                        <th>Cities</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr = 1; @endphp
                                    @foreach ($zones as $zone)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $zone->name }}</td>
                                            <td>{{ implode(', ', json_decode($zone->countries)) }}</td>
                                            <td>{{ isset($zone->cities)  ? implode(', ', json_decode($zone->cities)) : 'All Cities' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($zone->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.shipping-zones.edit', $zone->id) }}" class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)" data-href="{{ route('admins.shipping-zones.destroy', $zone->id) }}" class="btn btn-danger delete_record">Delete</a>
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