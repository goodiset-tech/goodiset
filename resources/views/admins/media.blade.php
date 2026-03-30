@extends('admins.master')

@section('title','Media')

@section('media','active')


@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Post Media Form</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" >
                            <label class="col-lg-4 control-label">Media:</label>
                            <div class="col-lg-8">
                            <input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : "required"; ?> accept="image/png, image/gif, image/jpeg" class="form-control" name="name">
                            <img src="<?php echo isset($edit->name) ? asset($edit->name) : null; ?>"  alt="" <?php echo isset($edit->name) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                            </div>
                            
                       
                        </div>
                        @if(isset($edit->id))
                        <input type="hidden" name="hidden_id" value="{{$edit->id}}">
                        @endif
                        <div class="form-group"><label class="col-lg-4 control-label"></label>

                            <div class="col-lg-8">                  <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
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
                <h5>Media List</h5>
            </div>
            <div class="ibox-content">
  
                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Media</th>
                <!--<th>Title Urdu</th>-->
                <th>Creation Ago</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
              @php $sr=1; @endphp
              @foreach ($categories as $item)
                  <tr>
                    <td>{{$sr++}}</td>
                    <td><a href="{{asset('')}}{{$item->name}}">{{$item->name}}</a></td>
                    <!--<td>{{$item->title_urdu}}</td>-->
                    <td>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</td>
            
                    <td>
                      <a href="{{route('admins.media')}}/{{$item->id}}" class="btn btn-warning">Edit</a>
                      <a href="javascript:void(0)" data-href="{{route('admins.media')}}/{{$item->id}}/{{'delete'}}"  class="btn btn-danger delete_record">Delete</a>
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