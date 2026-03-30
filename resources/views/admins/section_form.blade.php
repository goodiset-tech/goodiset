@extends('admins.master')
<style>
    label{
        text-align: left !important;
    }
    .bootstrap-tagsinput{
        width:100% !important;
    }
</style>
@section('title','Product Form')

@section('product_active','active')

@section('product_active_c1','collapse in')

@section('product_child_1_active','active')


@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Section Form</h5>
                </div>
                <div class="ibox-content">
                    <form action="/admin/page_form?section=1" class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group"><label class="col-sm-12 control-label">Section Name:</label>
                            <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->name) ? htmlspecialchars($edit->name) : null; ?>" required class="form-control" name="name"></div>
                        </div>
                        
                        <div class="form-group"><label class="col-sm-12 control-label">Page Sorting:</label>
                            <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->position) ? htmlspecialchars($edit->position) : null; ?>" required class="form-control" name="position"></div>
                        </div>
                        
                        @if($edit)
                        <div class="form-group"><label class="col-sm-12 control-label">Publish:</label>
                            <div class="col-sm-12">
                            <select required="" class="form-control" name="status">
                                <option value="1" <?= (isset($edit) && $edit->status == 1 ) ? "Selected" : ''; ?> >Active</option>
                                <option value="2" <?= (isset($edit) && $edit->status == 2 ) ? "Selected" : ''; ?>>Deactive</option>
                            </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group"><label class="col-sm-12 control-label">Parent Menu:</label>
                            <div class="col-sm-12">
                            <select required="" class="form-control" name="menu">
                                <option value="2" <?= (isset($edit) && $edit->menu == 0 ) ? "Selected" : ''; ?>>Parent Menu</option>
                                @foreach ($page as $spage)
                                    <option value="{{$spage->id}}" <?= (isset($edit) && $edit->menu == $spage->id ) ? "Selected" : ''; ?>>{{$spage->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                       
                        @if(isset($edit->id))
                        <input type="hidden" name="hidden_id" value="{{$edit->id}}">
                        @endif
                        <div class="form-group">
                            <div class="col-sm-10"><button class="btn btn-md btn-primary" type="submit"><strong>Save</strong></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
  </div>
@endsection

@push('scripts')

@endpush