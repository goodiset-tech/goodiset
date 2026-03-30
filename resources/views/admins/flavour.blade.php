@extends('admins.master')

@section('title', 'Flavour')

@section('flavour_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Flavour Form</h5>
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

                            <div class="form-group"><label class="col-lg-3 control-label">Name (Arabic)</label>
                                <div class="col-lg-9"><input type="text" required name="name_ar"
                                        value="{{ isset($edit->name_ar) ? $edit->name_ar : '' }}" class="form-control">
                                    @error('name_ar')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Color</label>
                                <div class="col-lg-9"><input type="color" required name="color"
                                        value="{{ isset($edit->color) ? $edit->color : '' }}" class="form-control">
                                    @error('color')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-3 control-label">Flavour</label>
                                <div class="col-lg-9">
                                    <input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : ''; ?>
                                        accept="image/png, image/gif, image/jpeg" class="form-control" name="banner">
                                    <img src="<?php echo isset($edit->banner) ? asset($edit->banner) : null; ?>" alt="" <?php echo isset($edit->banner) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                                </div>
                            </div>

                             <div class="form-group"><label class="col-lg-3 control-label">Show on the home page</label>
                                <div class="col-lg-9">
                                    <select name="show_home" class="form-control" required>
                                        <option value="1" {{ (isset($edit->show_home) && $edit->show_home == 1) ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ (isset($edit->show_home) && $edit->show_home == 0) ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('show_home')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
                        <h5>Flavour List</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($Flavour as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td style="background-color: {{ $item->color }}; width: 50px; height: 50px;">
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.flavour') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.flavour') }}/{{ $item->id }}/{{ 'delete' }}"
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
