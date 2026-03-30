<style>
    td{
        vertical-align: middle !important;
    }
    td img{
        width: 50px;
    }
</style>
@extends('admins.master')
@section('title', 'Pages')
@section('static_pages_active', 'active')
<?php
use App\Models\Admins\Category;
use App\Models\Admins\SubCategory;
use App\Models\Childcatagorie;
use App\Models\product;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Brand;
  ?>

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Static Page List</h5>
                <div class="ibox-tools">
                    {{-- <a href="{{ route('admins.page_form') }}" class="btn btn-primary btn-xs">Add Page</a> --}}
                </div>
            </div>
            <div class="ibox-content">
  
                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>#</th>
                <th>Page</th>
                <th>Link</th>
                <th>Banner</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($pages as $key=> $page)
                <tr>
                    
                    <td><?= $key+1 ?></td>
                    <td>{{$page->name}}</td>
                    <td><a href="{{ url('/' . $page->slug) }}" target="_blank">{{ $page->name }}</a></td>
                    <td>
                        <img src=" {{ asset('') }}img/slider/{{ $page->page_image }}"
                                            alt="" <?php echo $page->page_image != null ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                    </td>
                    <td>
                        <a href="{{route('admins.static_page_form',$page->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                        {{-- <a data-href="{{route('admins.page_delete',['id'=>$page->id])}}" class="btn btn-danger btn-sm delete_record" href="javascript:void(0)"><i class="fa fa-times"></i>&nbsp;Delete</a> --}}
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
      
       function updateStatus(status,product_id)
       {
            if(product_id>0){
                $.ajax({
                    headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                        },
                    url : "{{route('admins.update_product_status')}}",
                    type : "POST",
                    data : {
                        product_id : product_id,
                        Status : status,
                    },
                    success : function(response){
                        showToastr(response.msg,response.msg_type);
                    }
                });
            }
       }
      $(document).ready(function(){
          let status=0;
          let product_id=0;
          $('input[name="product_status"]').change(function(){
            if($(this).is(':checked')){
                status=1;
                product_id=$(this).data('id');
            }else{
                status=0;
                product_id=$(this).data('id');
            }
            updateStatus(status,product_id);
          });
      });
  </script>
@endpush