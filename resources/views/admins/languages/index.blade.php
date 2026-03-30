@extends('admins.master')

@section('title','Languages')
@section('languages_active','active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-6">
      <div class="ibox float-e-margins">
        <div class="ibox-title"><h5>Language Form</h5></div>
        <div class="ibox-content">
          <form class="form-horizontal" method="post" action="{{ isset($edit) ? route('admins.languages.edit',$edit->id) : route('admins.languages') }}">
            @csrf
            <div class="form-group">
              <label class="col-lg-3 control-label">Name</label>
              <div class="col-lg-9">
                <input type="text" required name="name" value="{{isset($edit)?$edit->name:''}}" class="form-control">
                @error('name') <span class="help-block m-b-none text-danger">{{$message}}</span> @enderror
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Code</label>
              <div class="col-lg-9">
                <input type="text" required name="code" value="{{isset($edit)?$edit->code:''}}" class="form-control" placeholder="en, ur, ar-SA">
                @error('code') <span class="help-block m-b-none text-danger">{{$message}}</span> @enderror
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label">Default?</label>
              <div class="col-lg-9">
                <input type="checkbox" name="is_default" value="1" {{ isset($edit) && $edit->is_default ? 'checked' : '' }}>
              </div>
            </div>

            @if(isset($edit))
              <input type="hidden" name="hidden_id" value="{{$edit->id}}">
            @endif

            <div class="form-group">
              <label class="col-lg-3 control-label"></label>
              <div class="col-lg-9">
                <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="ibox float-e-margins">
        <div class="ibox-title"><h5>Languages</h5></div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example">
              <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Default</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @php $sr=1; @endphp
              @foreach ($languages as $l)
                <tr>
                  <td>{{$sr++}}</td>
                  <td>{{$l->name}}</td>
                  <td>{{$l->code}}</td>
                  <td>{!! $l->is_default ? '<span class="label label-primary">Yes</span>' : 'No' !!}</td>
                  <td>
                    <a href="{{route('admins.languages.edit',$l->id)}}" class="btn btn-warning btn-xs">Edit</a>
                    <a href="{{route('admins.translations',$l->code)}}" class="btn btn-info btn-xs">Manage Translations</a>
                    @if(!$l->is_default)
                      <a href="{{route('admins.languages.default',$l->id)}}" class="btn btn-success btn-xs">Make Default</a>
                      <a href="{{route('admins.languages.delete',$l->id)}}" class="btn btn-danger btn-xs delete_record">Delete</a>
                    @endif
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
