@extends('admins.master')

@section('campaign-emails', 'active')

@section('title', 'Campaign Emails')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="card-header flex-column flex-md-row border-bottom p-0">
                        <div class="row m-0 pb-2 mb-2">
                            <div class="col-sm-6 p-0">
                                <div class="head-label">
                                    <h5 class="card-title mb-0 pt-2">Campaign Emails</h5>
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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Guests</th>
                                        <th>Time</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $user)
                                        <tr>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->name ?? "--" }}</td>
                                            <td>{{ $user->guests ?? "--" }}</td>
                                            <td>
                                                {{ $user->time }}
                                            </td>
                                            <td>
                                                {{ date('F j, Y', strtotime($user->created_at)) }}
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
    <!-- Content wrapper -->

@endsection
