@extends('admins.master')

@section('title', 'Add home page video')

@section('product_active_c1', 'collapse in')
@section('home_videos', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Add home page video</h5>
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
                    <form method="POST" action="{{ route('admins.home-videos.store') }}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title (EN)</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Optional caption on homepage">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title (AR)</label>
                            <div class="col-sm-10">
                                <input type="text" name="title_ar" dir="rtl" class="form-control" value="{{ old('title_ar') }}" placeholder="اختياري">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Video file *</label>
                            <div class="col-sm-10">
                                <input type="file" name="video" class="form-control"
                                    accept=".mp4,.webm,.mov,.m4v,.avi,.mkv,.ogv,.3gp,video/*" required>
                                <span class="help-block m-b-none">
                                    Allowed: MP4, MOV, WebM, M4V, AVI, MKV, OGV, 3GP. Max <strong>{{ $maxUploadMb ?? 500 }} MB</strong> (set in <code>HOME_VIDEO_MAX_UPLOAD_KB</code> / <code>config/home_videos.php</code>).
                                    Ensure PHP <code>upload_max_filesize</code> and <code>post_max_size</code> (and nginx <code>client_max_body_size</code> if used) are at least that large.
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Poster image</label>
                            <div class="col-sm-10">
                                <input type="file" name="poster" class="form-control" accept="image/jpeg,image/png,image/webp">
                                <span class="help-block m-b-none">
                                    Optional. If omitted, a poster is generated from the video when <strong>ffmpeg</strong> is installed on the server (see <code>HOME_VIDEO_FFMPEG</code> / <code>HOME_VIDEO_EXTRACT_POSTER</code> in <code>.env</code>).
                                    Manual upload: JPEG, PNG, WebP, max 5 MB.
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sort order</label>
                            <div class="col-sm-10">
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="1" @selected(old('status', '1') == '1')>Active (show on homepage)</option>
                                    <option value="0" @selected(old('status') == '0')>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
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
