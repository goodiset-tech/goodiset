@extends('admins.master')

@section('title', 'Edit home page video')

@section('product_active_c1', 'collapse in')
@section('home_videos', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit home page video</h5>
                </div>
                <div class="ibox-content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-b-none">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admins.home-videos.update', $video) }}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Current video</label>
                            <div class="col-sm-10">
                                <video src="{{ asset($video->video_path) }}" controls style="max-width:320px;max-height:180px;" preload="metadata"></video>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Replace video</label>
                            <div class="col-sm-10">
                                <input type="file" name="video" class="form-control"
                                    accept=".mp4,.webm,.mov,.m4v,.avi,.mkv,.ogv,.3gp,video/*">
                                <span class="help-block m-b-none">
                                    Leave empty to keep current file. Max <strong>{{ $maxUploadMb ?? 500 }} MB</strong>.
                                    Replacing the video rebuilds the auto-poster (ffmpeg) unless you upload a poster below.
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title (EN)</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" value="{{ old('title', $video->title) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title (AR)</label>
                            <div class="col-sm-10">
                                <input type="text" name="title_ar" dir="rtl" class="form-control" value="{{ old('title_ar', $video->title_ar) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Poster image</label>
                            <div class="col-sm-10">
                                @if ($video->poster_path)
                                    <p><img src="{{ asset($video->poster_path) }}" alt="" style="max-width:120px;"></p>
                                @endif
                                <input type="file" name="poster" class="form-control" accept="image/jpeg,image/png,image/webp">
                                <span class="help-block m-b-none">Optional manual poster (replaces auto screenshot).</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sort order</label>
                            <div class="col-sm-10">
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $video->sort_order) }}" min="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="1" @selected(old('status', $video->status ? '1' : '0') == '1')>Active</option>
                                    <option value="0" @selected(old('status', $video->status ? '1' : '0') == '0')>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admins.home-videos.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
