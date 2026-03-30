@extends('admins.master')

@section('title', 'Create Blog')

@section('blogs', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Create New Blog</h5>
                </div>
                <div class="ibox-content">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admins.blogs.store') }}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title Ar</label>
                            <div class="col-sm-10">
                                <input type="text" name="title_ar" dir="rtl" class="form-control" value="{{ old('title_ar') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10">
                                <select name="blog_category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Content</label>
                            <div class="col-sm-10">
                                <textarea name="content" class="form-control summernote" rows="10" required>{{ old('content') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Short Description</label>
                            <div class="col-sm-10">
                                <textarea name="short_description" class="form-control" rows="4">{{ old('short_description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Content Ar</label>
                            <div class="col-sm-10">
                                <textarea name="content_ar" dir="rtl" class="form-control summernote" rows="10" required>{{ old('content_ar') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Short Description Ar</label>
                            <div class="col-sm-10">
                                <textarea name="short_description_ar" dir="rtl" class="form-control" rows="4">{{ old('short_description_ar') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Main Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Read Time (minutes)</label>
                            <div class="col-sm-10">
                                <input type="number" name="read_time" class="form-control" value="{{ old('read_time') }}" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Added By</label>
                            <div class="col-sm-10">
                                <input type="text" name="added_by" class="form-control" value="{{ old('added_by', auth()->user()->name ?? '') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control" required>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Save Blog</button>
                                <a href="{{ route('admins.blogs.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection