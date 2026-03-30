@extends('admins.master')

@section('title','Brand')

@section('category_active','active')

@section('category_active_c3','collapse in')

@section('category_child_3_active','active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Brand Form</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group"><label class="col-lg-3 control-label">Brand</label>
                            <div class="col-lg-9"><input type="text" required name="name" value="{{isset($edit->name) ? $edit->name : ""}}"  class="form-control">
                                @error('name')
                                <span class="help-block m-b-none text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-3 control-label">Upload Brand Logo</label>

                            <div class="col-lg-9">
                                <input type="file" accept="image/*"  <?php echo isset($edit->id) ? '' :  ''; ?> name="logo" id="">
                                @error('logo')
                                <span class="help-block m-b-none text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        @if(isset($edit->id))
                        <div class="form-group"><label class="col-lg-3 control-label">Already Uploaded Logo</label>
                            <div class="col-lg-9">
                                <img src="{{asset($edit->brand_logo)}}" alt="">
                            </div>
                        </div>
                        
                        <input type="hidden" name="hidden_id" value="{{$edit->id}}">
                        @endif
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Seo Title:</label>
                            <div class="col-lg-9">
                                <input type="text"  class="form-control" required value="<?php echo isset($seo->title) ? htmlspecialchars($seo->title) : null; ?>" name="stitle" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Seo Description:</label>
                            <div class="col-lg-9">
                                <input type="text"  class="form-control" required value="<?php echo isset($seo->description) ? htmlspecialchars($seo->description) : null; ?>" name="sdescription" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Seo keywords:</label>
                            <div class="col-lg-9">
                                <input type="text"  class="form-control" required value="<?php echo isset($seo->keywords) ? htmlspecialchars($seo->keywords) : null; ?>" name="skeywords" >
                            </div>
                        </div>
                        @if(isset($edit->id))
                        <input type="hidden" name="previous_logo" value="{{$edit->brand_logo}}">
                        @endif
                        <div class="form-group"><label class="col-lg-3 control-label"></label>

                            <div class="col-lg-9">                  <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
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
                <h5>Category List</h5>
            </div>
            <div class="ibox-content">
  
                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Sub Category</th>
                <th>Brand Logo</th>
                <th>Creation Ago</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
              @php $sr=1; @endphp
              @foreach ($brands as $item)
                  <tr>
                    <td>{{$sr++}}</td>
                    <td>{{$item->name}}</td>
                    <td><img src="{{asset($item->brand_logo)}}" alt="" width="100px" height="100px"></td>
                    <td>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</td>
                    <td>
                      <a href="{{route('admins.brand')}}/{{$item->id}}" class="btn btn-warning">Edit</a>
                      <a href="javascript:void(0)" data-href="{{route('admins.brand')}}/{{$item->id}}/{{'delete'}}"  class="btn btn-danger delete_record">Delete</a>
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