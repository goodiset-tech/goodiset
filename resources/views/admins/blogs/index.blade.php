@extends('admins.master')

@section('title', 'Blogs')

@section('blogs', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Blogs List</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('admins.blogs.create') }}" class="btn btn-primary btn-xs">Add New Blog</a>
                        <a href="{{ route('admins.blogs.categories.index') }}" class="btn btn-primary btn-xs">Manage Categories</a>
                        <a href="{{ route('admins.home-videos.index') }}" class="btn btn-primary btn-xs">Home page videos</a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover blogs-table">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Slug</th>
                                    <th>Short Description</th>
                                    <th>Read Time</th>
                                    <th>Added By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr = 1; @endphp
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>
                                            @if ($blog->image)
                                                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" style="width: 50px; height: auto;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->category->name ?? 'Uncategorized' }}</td>
                                        <td>{{ $blog->slug }}</td>
                                        <td>{{ Str::limit($blog->short_description ?? '', 50) }}</td>
                                        <td>{{ $blog->read_time ? $blog->read_time . ' min' : 'N/A' }}</td>
                                        <td>{{ $blog->added_by ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge {{ $blog->status ? 'badge-primary' : 'badge-danger' }}">
                                                {{ $blog->status ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admins.blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="javascript:void(0)" data-href="{{ route('admins.blogs.destroy', $blog->id) }}" 
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
    $('.blogs-table').DataTable({
        pageLength: 25,
        responsive: true
    });

    $(document).on('click', '.delete_record', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to delete this blog?')) {
            window.location = $(this).data('href');
        }
    });
});
</script>
@endpush