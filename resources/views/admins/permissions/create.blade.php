@extends('admins.master')

@section('users', 'active')

@section('title', 'Permission')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="card-header flex-column flex-md-row border-bottom p-0">
                            <div class="row m-0 pb-2 mb-2">
                                <div class="col-lg-6 col-sm-12 p-0">
                                    <div class="head-label">
                                        <h5 class="card-title mb-0 pt-2">Create Permission</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <form action="{{ route('admins.permissions.store') }}" method="POST">
                                @csrf
                                <div class="form-floating form-floating-outline mb-3">
                                    <label for="Name">Module Name</label>
                                    <input type="text" class="form-control" name="module_name" placeholder="Enter Name">
                                    
                                </div>


                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Create Permission</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
