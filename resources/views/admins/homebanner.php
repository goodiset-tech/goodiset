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
                    <h5>Page Form</h5>
                </div>
                <div class="ibox-content">
                    <form action="/admin/setting" class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Header Logo:</label>
                            <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                            <div class="col-sm-12"><input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : "required"; ?> accept="image/png, image/gif, image/jpeg" class="form-control" name="logo">
                            <img src="<?php echo isset($edit->logo) ? asset($edit->logo) : null; ?>"  alt="" <?php echo ($edit->logo != null) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>></div>
                        </div>
                        <div class="form-group"><label class="col-sm-12 control-label">Header Email:</label>
                            <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->email) ? htmlspecialchars($edit->email) : null; ?>" required class="form-control" name="email"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-12 control-label">Header Text:</label>
                            <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->text) ? htmlspecialchars($edit->text) : null; ?>" required class="form-control" name="text"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-12 control-label">Phone Number:</label>
                            <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->phone) ? htmlspecialchars($edit->phone) : null; ?>" required class="form-control" name="phone"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Footer Logo:</label>
                            <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                            <div class="col-sm-12"><input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : "required"; ?> accept="image/png, image/gif, image/jpeg" class="form-control" name="footer_logo">
                            <img src="<?php echo isset($edit->footer_logo) ? asset($edit->footer_logo) : null; ?>"  alt="" <?php echo ($edit->footer_logo != null) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Footer Text:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="footer_text"><?php echo ($edit->footer_text != null) ? asset($edit->footer_text) : ''; ?></textarea>
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

<script>

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $(input).parent().find('img').attr('src', e.target.result).show();
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    
</script>

@endpush