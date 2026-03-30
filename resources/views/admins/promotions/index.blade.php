@extends('admins.master')

@section('title', 'Promotions')

@section('promotion_active', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Promotions List</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('admins.promotions.create') }}" class="btn btn-primary btn-xs">Add Promotion</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Discount</th>
                                    <th>Cart Minimum</th>
                                    <th>Customer Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr = 1; @endphp
                                @foreach ($promotions as $promotion)
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>{{ $promotion->name }}</td>
                                        <td>{{ ucfirst($promotion->type) }}</td>
                                        <td>
                                            @if ($promotion->type == 'percentage')
                                                {{ $promotion->discount }}%
                                            @elseif ($promotion->type == 'amount')
                                                {{ $promotion->discount }} <span class="icon-aed">{{ getSetting('currency') }}</span>
                                            @else
                                                Free Products:
                                                <ul>
                                                    @foreach (json_decode($promotion->product_ids, true) as $productId)
                                                        @php
                                                            $product = \App\Models\Admins\Product::find($productId);
                                                        @endphp
                                                        @if ($product)
                                                            <li>{{ $product->product_name }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td>{{ $promotion->cart_minimum }} <span class="icon-aed">{{ getSetting('currency') }}</span></td>
                                        <td>{{ ucfirst($promotion->customer_type) }}</td>
                                        <td>{{ $promotion->start_date }}</td>
                                        <td>{{ $promotion->end_date }}</td>
                                        <td>
                                            <span class="badge badge-{{ $promotion->status ? 'success' : 'danger' }}">
                                                {{ $promotion->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admins.promotions.edit', $promotion->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admins.promotions.destroy', $promotion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete-confirm">Delete</button>
                                            </form>
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
