@extends('admins.master')

@section('title', 'Theme')

@section('theme_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Theme Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><label class="col-lg-3 control-label">Name</label>
                                <div class="col-lg-9"><input type="text" required name="name"
                                        value="{{ isset($edit->name) ? $edit->name : '' }}" class="form-control">
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Upload Image</label>

                                <div class="col-lg-9">
                                    <input type="file" accept="image/*" <?php echo isset($edit->id) ? '' : 'required'; ?> name="image"
                                        id="">
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if (isset($edit->id))
                                <div class="form-group"><label class="col-lg-3 control-label">Already Uploaded Image</label>
                                    <div class="col-lg-9">
                                        <img src="{{ asset($edit->image) }}" alt="">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Theme Banner:</label>
                                <input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : ''; ?>
                                    accept="image/png, image/gif, image/jpeg" class="form-control" name="banner">
                                <img src="<?php echo isset($edit->banner) ? asset($edit->banner) : null; ?>" alt="" <?php echo isset($edit->banner) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>

                            </div>
                            @if (isset($edit->id))
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif



                            <div class="form-group"><label class="col-lg-3 control-label"></label>

                                <div class="col-lg-9"> <button class="btn btn-sm btn-primary"
                                        type="submit"><strong>Save</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Theme List</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($Theme as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><img src="{{ asset($item->image) }}" width="100" height="100"
                                                    alt=""></td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.theme') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.theme') }}/{{ $item->id }}/{{ 'delete' }}"
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
