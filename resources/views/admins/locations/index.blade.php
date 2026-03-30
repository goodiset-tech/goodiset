@extends('admins.master')

@section('locations_active', 'active')

@section('title', 'Locations')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="card-header flex-column flex-md-row border-bottom p-0 ibox-content">
                        <div class="row m-0 pb-2 mb-2">
                            <div class="col-sm-6 p-0">
                                <div class="head-label">
                                    <h5 class="card-title mb-0 pt-2">Locations</h5>
                                </div>
                            </div>
                            <div class="col-sm-4 p-0">
                            </div>
                            <div class="col-sm-2 p-0">
                                <div class="head-label">
                                    <a href="{{ route('admins.locations.create') }}" class="btn btn-primary">Create New Location</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr #</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Location Name</th>
                                        <th>Address</th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Phone</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($locations as $location)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $location->name }}</td>
                                            <td>{{ ucfirst($location->type ?? '--') }}</td>
                                            <td>{{ $location->location_name ?? '--' }}</td>
                                            <td>{{ $location->address ?? '--' }}</td>
                                            <td>{{ $location->contact_name ?? '--' }}</td>
                                            <td>{{ $location->contact_email ?? '--' }}</td>
                                            <td>{{ $location->contact_phone ?? '--' }}</td>
                                            <td>{{ date('F j, Y', strtotime($location->created_at)) }}</td>
                                            <td>
                                                <a href="{{ route('admins.locations.edit', $location->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('admins.locations.destroy', $location->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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