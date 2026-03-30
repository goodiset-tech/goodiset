@extends('admins.master')

@section('title', 'Offers')

@section('offer_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Offers List</h5>
                        <div class="ibox-tools">
                            {{-- @if ($offers->count() == 0) --}}
                            <a href="{{ route('admins.offers.create') }}" class="btn btn-primary btn-xs">Add Offer</a>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Discount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($offers as $offer)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $offer->name }}</td>
                                            <td>{{ $offer->discount }}
                                                {!! $offer->type == 'percentage' ? '%' : '<span class="icon-aed">' . getSetting('currency') . '</span>' !!}</td>
                                            <td>{{ $offer->start_date }}</td>
                                            <td>{{ $offer->end_date }}</td>
                                            <td>
                                                <span class="badge badge-{{ $offer->status ? 'success' : 'danger' }}">
                                                    {{ $offer->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admins.offers.edit', $offer->id) }}"
                                                    class="btn-sm btn btn-warning">Edit</a>
                                                <form action="{{ route('admins.offers.destroy', $offer->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
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
