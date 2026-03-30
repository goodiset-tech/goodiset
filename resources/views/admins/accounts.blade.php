@extends('admins.master')

@section('account_active', 'active')

@section('title', 'Accounts')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="card-header flex-column flex-md-row border-bottom p-0">
                        <div class="row m-0 pb-2 mb-2">
                            <div class="col-sm-6 p-0">
                                <div class="head-label">
                                    <h5 class="card-title mb-0 pt-2">Accounts</h5>
                                </div>
                            </div>
                            <div class="col-sm-4 p-0">
                            </div>
                            <div class="col-sm-2 p-0">
                                {{-- <div class="head-label">
                                    <a href="{{ route('admins.users.create') }}" class="btn btn-primary">Create New User</a>
                                </div> --}}
                            </div>

                        </div>

                    </div>
                    <div class="ibox-content">
                        <form method="GET" action="{{ route('admins.accounts') }}" class="mb-4"
                            style="margin-bottom: 10px">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                        placeholder="Enter name">
                                </div>

                                <div class="col-md-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" value="{{ request('email') }}" class="form-control"
                                        placeholder="Enter email">
                                </div>

                                <div class="col-md-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" value="{{ request('phone') }}" class="form-control"
                                        placeholder="Enter phone">
                                </div>

                                <div class="col-md-3">
                                    <label for="start_date">Start Purchase Date</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="end_date">End Purchase Date</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-3 mt-5" style="margin-top:20px">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                                    <a href="{{ route('admins.accounts') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr #</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>City</th> <!-- Added -->
                                        <th>Country</th> <!-- Added -->
                                        <th>First Purchase Date</th>
                                        <th>No. of Orders</th>
                                        <th>Total Purchase Amount</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($data as $user)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $user->name ?? '--' }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone ?? '--' }}</td>
                                            <td>{{ $user->city ?? '--' }}</td> <!-- Added -->
                                            <td>{{ $user->country ?? '--' }}</td> <!-- Added -->
                                            <td>{{ $user->first_purchase_date ? date('F j, Y', strtotime($user->first_purchase_date)) : '--' }}
                                            </td>
                                            <td>{{ $user->order_count ?? 0 }}</td>
                                            <td>{{ number_format($user->total_purchase_amount ?? 0, 2) }}
                                                <span class="icon-aed">{{ getSetting('currency') }}</span></td>
                                            <td>{{ date('F j, Y', strtotime($user->created_at)) }}</td>
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
    <!-- Content wrapper -->

@endsection
