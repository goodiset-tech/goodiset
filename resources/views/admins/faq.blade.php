@extends('admins.master')

@section('title','Faq')

@section('faq','active')


@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Faq's List</h5>
            </div>
            <div class="ibox-content">
  
                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>Questions</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
              @php $sr=1; @endphp
              @foreach ($sliders as $item)
                  <tr>
                    <td>{{$sr++}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->question}}</td>
            
                    <td>
                        <a href="javascript:void(0)" data-href="{{route('admins.faq')}}/{{$item->id}}/{{'delete'}}"  class="btn btn-danger delete_record">Delete</a>
                        <a href="{{route('admins.faq')}}/{{$item->id}}" class="btn btn-warning">Edit</a>
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
