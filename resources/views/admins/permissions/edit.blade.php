@extends('admins.master')

@section('permission', 'active')

@section('title', 'Demand Detail')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y pt-2">
            <div class="card">
                <div class="table-responsive p-3">
                    <div class="card-header flex-column flex-md-row border-bottom p-0">
                        <div class="row m-0 pb-2 mb-2">
                            <div class="col-lg-6 col-sm-12 p-0">
                                <div class="head-label">
                                    <h5 class="card-title mb-0 pt-2">Update Permission</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" value="{{ $permission->module_name }}" name="module_name" placeholder="Enter Name">
                                <label for="Name">Name</label>
                            </div>


                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Update Permission</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div
                    class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                    <div class="text-body mb-2 mb-md-0">Copyright © CIP 2024. All Rights Reserved.</div>
                </div>
            </div>
        </footer>
        <!-- / Footer -->
        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

@endsection
