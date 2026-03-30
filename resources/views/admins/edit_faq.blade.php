@extends('admins.master')

@section('title','Faq')

@section('faq','active')


@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Order Form</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="faq" method="post" action="/admin/faq" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$edit->id}}">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group"><label class="col-sm-12 ">Customer Name:</label>
                                    <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->name) ? htmlspecialchars($edit->name) : null; ?>" readonly required class="form-control" name=""></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group"><label class="col-sm-12 ">Answered By:</label>
                                    <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->a_name) ? htmlspecialchars($edit->a_name) : null; ?>"  required class="form-control" name="a_name"></div>
                                </div>
                            </div>
                             <div class="col-sm-4">
                                <div class="form-group"><label class="col-sm-12 ">Status:</label>
                                
                                    <div class="col-sm-12">
                                        <select  class="form-control" name="status">
                                        <option <?php if($edit->status == 1 ){echo "selected"; } ?> value="1">Active</option>
                                        <option <?php if($edit->status == 0 ){echo "selected"; } ?> value="0">Un-active</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            
                            <div class="col-sm-4">
                                <div class="form-group"><label class="col-sm-12 ">Customer Question:</label>
                                <div class="col-sm-12"><textarea class="summernote" name="question" id="question" style="height:500px">
                                            <?php echo isset($edit->question) ? htmlspecialchars($edit->question) : null; ?>
        
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group"><label class="col-sm-12 ">Answer:</label>
                                <div class="col-sm-12"><textarea class="summernote" name="answer" id="answer" style="height:500px">
                                            <?php echo isset($edit->answer) ? htmlspecialchars($edit->answer) : null; ?>
        
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                           <input type="hidden" name="hidden_id" value="{{$edit->id}}">
                        </div>
                       
                       
                        
                        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                        <div class="form-group">
                            <div class="col-sm-10"><button class="btn btn-md btn-primary" type="submit"><strong>Save</strong></button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div>
                    
                </div>
            </div>
        </div>
      </div>
  </div>
@endsection
@push('scripts')

<script>
    
        
    $(document).ready(function() {
        $(document).on("submit","#faq",function(e){
            // alert( $('#short_discriiption').summernote('code'));
    $("#answer").val($('#answer').summernote('code'));
    $("#question").val($('#question').summernote('code'));
    
    return true;
    // e.preventDefault();
});

$(document).on("submit","#faq",function(e){
    if ($('#question').summernote('codeview.isActivated')) {
        $('#question').summernote('codeview.deactivate'); 
    }
    if ($('#answer').summernote('codeview.isActivated')) {
        $('#answer').summernote('codeview.deactivate'); 
    }
});
     
    

    
    
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
