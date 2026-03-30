@extends('admins.master')

@section('title','Update_admin')

 @section('admin','active')


@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Admin</h5>
                </div>
                <div class="ibox-content">
                    @foreach($edit as $v)
                    <form class="form-horizontal" action="/admin/update_admin" id="slider_form" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email</label>
                            <div class="col-lg-9">
                                <input value="{{$v->email}}" name="email" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-9">
                                <input value="" name="pass" class="form-control">
                            </div>
                        </div>
                        
                        <input type="hidden" name="id" value="{{$v->id}}">
                        <div class="form-group"><label class="col-lg-3 control-label"></label>

                            <div class="col-lg-9">                  <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
  </div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
        $(document).on("submit","#slider_form",function(e){
    $("#short_discriiption").val($('#short_discriiption').summernote('code'));
    
    return true;
    // e.preventDefault();
});

$(document).on("submit","#slider_form",function(e){
    if ($('#short_discriiption').summernote('codeview.isActivated')) {
        $('#short_discriiption').summernote('codeview.deactivate'); 
    }
});
});
</script>
@endpush
