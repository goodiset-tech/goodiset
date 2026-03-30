@extends('admins.master')

@section('title', 'Category')

@section('category_active', 'active')

@section('category_child_1_active', 'active')

@section('category_active_c1', 'collapse in')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Category List</h5>
                        <div class="ibox-tools">
                            <button class="btn btn-primary btn-sm text-white">
                                <a href="{{ route('admins.category') }}" style="color: white;">Add Category</a>
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <!--<th>Image</th>-->
                                        <th>Category</th>
                                        <th>Category Type</th>
                                        <th>Show On Home</th>
                                        <th>Show In Mega Menu</th>
                                        <th>Show Product On Home Page</th>
                                        <th>Visits</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <!--<td><img src="{{ asset($item->image) }}" style="width:50px;" ></td>-->
                                            <td><a href="{{ route('category.show', $item->slug) }}"
                                                    target="_blank">{{ $item->name }}</a>
                                            </td>
                                            <td>{{ $item->is_manual == 1 ? 'Manual' : 'Smart' }}</td>
                                            <td>{{ $item->home_cat == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->mega_menu == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->status == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->view }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.category') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.category') }}/{{ $item->id }}/{{ 'delete' }}"
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
