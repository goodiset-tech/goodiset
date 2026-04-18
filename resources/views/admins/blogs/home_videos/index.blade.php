@extends('admins.master')

@section('title', 'Home page videos')

@section('product_active_c1', 'collapse in')
@section('home_videos', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Home page videos</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('admins.blogs.index') }}" class="btn btn-default btn-xs">Back to blogs</a>
                        <a href="{{ route('admins.home-videos.create') }}" class="btn btn-primary btn-xs">Add video</a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Preview</th>
                                    <th>Title</th>
                                    <th>Title (AR)</th>
                                    <th>Sort</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($videos as $video)
                                    <tr>
                                        <td>{{ $video->id }}</td>
                                        <td>
                                            @if ($video->poster_path)
                                                <img src="{{ asset($video->poster_path) }}" alt="" style="width:80px;height:auto;">
                                            @else
                                                <video src="{{ asset($video->video_path) }}" muted playsinline style="width:100px;max-height:56px;" preload="metadata"></video>
                                            @endif
                                        </td>
                                        <td>{{ $video->title ?: '—' }}</td>
                                        <td dir="rtl">{{ $video->title_ar ?: '—' }}</td>
                                        <td>{{ $video->sort_order }}</td>
                                        <td>
                                            <span class="badge {{ $video->status ? 'badge-primary' : 'badge-danger' }}">
                                                {{ $video->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admins.home-videos.edit', $video) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admins.home-videos.destroy', $video) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this video?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No videos yet. <a href="{{ route('admins.home-videos.create') }}">Add one</a>.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
