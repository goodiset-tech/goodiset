<style>
    td{
        vertical-align: middle !important;
    }
    td img{
        width: 50px;
    }
</style>
@extends('admins.master')

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
                <h5>Section List</h5>
            </div>
            <div class="ibox-content">
  
                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>#</th>
                <th>Section</th>
                <th>Parent Menu</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($pages as $key=> $page)
                <tr>
                    
                    <td><?= $key+1 ?></td>
                    <td>{{$page->name}}</td>
                    <td>{{$page->menu}}</td>
                    <td>
                        <a href="{{route('admins.page_form',$page->id)}}?section=1" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                        <a data-href="{{route('admins.section_delete',['id'=>$page->id])}}" class="btn btn-danger btn-sm delete_record" href="javascript:void(0)"><i class="fa fa-times"></i>&nbsp;Delete</a>
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