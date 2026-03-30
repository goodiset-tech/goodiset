@extends('admins.master')

@section('title', 'Blog Categories')

@section('blogs', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Blog Categories List</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('admins.blogs.categories.create') }}" class="btn btn-primary btn-xs">Add New Category</a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover categories-table">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr = 1; @endphp
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            <a href="{{ route('admins.blogs.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="javascript:void(0)" data-href="{{ route('admins.blogs.categories.destroy', $category->id) }}" 
                                               class="btn btn-danger btn-sm delete_record">Delete</a>
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

@push('scripts')
<script>
$(document).ready(function() {
    $('.categories-table').DataTable({
        pageLength: 25,
        responsive: true
    });

    $(document).on('click', '.delete_record', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to delete this category?')) {
            window.location = $(this).data('href');
        }
    });
});
</script>
@endpush