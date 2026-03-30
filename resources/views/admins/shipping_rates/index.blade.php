@extends('admins.master')

@section('shipping_active_c1', 'active')
@section('shipping_rate', 'active')
@section('title', 'Shipping Rates')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Shipping Rate List</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('admins.shipping-rates.create') }}" class="btn btn-primary btn-xs">Add Shipping Rate</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Zone</th>
                                        <th>Method</th>
                                        <th>Condition</th>
                                        <th>Min Value</th>
                                        <th>Max Value</th>
                                        <th>Rate</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr = 1; @endphp
                                    @foreach ($rates as $rate)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $rate->zone->name }}</td>
                                            <td>{{ $rate->method->name }}</td>
                                            <td>{{ $rate->condition_type ?? 'None' }}</td>
                                            <td>{{ $rate->min_value ?? 'N/A' }}</td>
                                            <td>{{ $rate->max_value ?? 'N/A' }}</td>
                                            <td>${{ $rate->rate }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rate->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.shipping-rates.edit', $rate->id) }}" class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)" data-href="{{ route('admins.shipping-rates.destroy', $rate->id) }}" class="btn btn-danger delete_record">Delete</a>
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