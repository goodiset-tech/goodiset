@extends('admins.master')

@section('title', 'Announcements')

@section('announcements_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Announcements Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><label class="col-lg-3 control-label">Top bar Text</label>
                                <div class="col-lg-9">
                                    <textarea name="text" id="" class="form-control" cols="30" rows="10">{{ isset($edit->text) ? $edit->text : '' }}</textarea>
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Top bar Text Ar</label>
                                <div class="col-lg-9">
                                    <textarea name="text_ar" dir="rtl" id="" class="form-control" cols="30" rows="10">{{ isset($edit->text_ar) ? $edit->text_ar : '' }}</textarea>
                                    @error('text_ar')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Status</label>
                                <div class="col-lg-9">
                                    <select name="status" id="" class="form-control">
                                        <option value="">Selected Status</option>
                                        <option value="active"
                                            {{ isset($edit->status) && $edit->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ isset($edit->status) && $edit->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('name')
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
                        <h5>Announcements List</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($announcements as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $item->text }}</td>
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.announcements') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.announcements') }}/{{ $item->id }}/{{ 'delete' }}"
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
