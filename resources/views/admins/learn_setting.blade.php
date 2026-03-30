@extends('admins.master')
<style>
    label{
        text-align: left !important;
    }
    .bootstrap-tagsinput{
        width:100% !important;
    }
</style>
@section('title','Learn Setting')

@section('learn_setting','active')




@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Learn Setting Form</h5>
                </div>
                <div class="ibox-content">
                    <form action="/admin/learn_setting" class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Learn Image 1:</label>
                            <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                            <div class="col-sm-12"><input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : "required"; ?> accept="image/png, image/gif, image/jpeg" class="form-control" name="learn_img_1">
                            <img src="<?php echo isset($edit->learn_img_1) ? asset($edit->learn_img_1) : null; ?>"  alt="" <?php echo ($edit->learn_img_1 != null) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Learn Image 2:</label>
                            <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                            <div class="col-sm-12"><input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : "required"; ?> accept="image/png, image/gif, image/jpeg" class="form-control" name="learn_img_2">
                            <img src="<?php echo isset($edit->learn_img_2) ? asset($edit->learn_img_2) : null; ?>"  alt="" <?php echo ($edit->learn_img_2 != null) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Learn Image 3:</label>
                            <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                            <div class="col-sm-12"><input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : "required"; ?> accept="image/png, image/gif, image/jpeg" class="form-control" name="learn_img_3">
                            <img src="<?php echo isset($edit->learn_img_3) ? asset($edit->learn_img_3) : null; ?>"  alt="" <?php echo ($edit->learn_img_3 != null) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>></div>
                        </div>
                        
                        
                        <div class="form-group"><label class="col-sm-12 control-label">Learn Text 1:</label>
                            <div class="col-sm-12">
                                <textarea class="summernote" name="p_1" rows="5">
                                    <?php echo isset($edit->p_1) ? htmlspecialchars($edit->p_1) : null; ?>
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group"><label class="col-sm-12 control-label">Learn Text 2:</label>
                            <div class="col-sm-12">
                                <textarea class="summernote" name="p2" rows="5">
                                    <?php echo isset($edit->p2) ? htmlspecialchars($edit->p2) : null; ?>
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group"><label class="col-sm-12 control-label">Learn Text 3:</label>
                            <div class="col-sm-12">
                                <textarea class="summernote" name="p3" rows="5">
                                    <?php echo isset($edit->p3) ? htmlspecialchars($edit->p3) : null; ?>
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group"><label class="col-sm-12 control-label">Learn Text 4:</label>
                            <div class="col-sm-12">
                                <textarea class="summernote" name="p4" rows="5">
                                    <?php echo isset($edit->p4) ? htmlspecialchars($edit->p4) : null; ?>
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group"><label class="col-sm-12 control-label">Learn Text 5:</label>
                            <div class="col-sm-12">
                                <textarea class="summernote" name="p5" rows="5">
                                    <?php echo isset($edit->p5) ? htmlspecialchars($edit->p5) : null; ?>
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group"><label class="col-sm-12 control-label">Learn Text 6:</label>
                            <div class="col-sm-12">
                                <textarea class="summernote" name="p6" rows="5">
                                    <?php echo isset($edit->p6) ? htmlspecialchars($edit->p6) : null; ?>
                                </textarea>
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