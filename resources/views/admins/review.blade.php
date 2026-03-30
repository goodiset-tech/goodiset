<style>
    td{
        vertical-align: middle !important;
    }
    td img{
        width: 50px;
    }
</style>
@extends('admins.master')

@section('title','Review')

@section('review','active')

@section('review_active_c1','collapse in')

@section('review_child_1_active','active')



<?php
use App\Models\Admins\Category;
use App\Models\Admins\SubCategory;
use App\Models\Childcatagorie;
use App\Models\Admins\Product;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Brand;
  ?>

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Subcriber List</h5>
            </div>
            <div class="ibox-content">
                <form method="POST" action="{{route('admins.delete_review')}}">
                <button type="submit" class="btn btn-danger btn-sm "><i class="fa fa-times"></i>Delete Selected</button>
  
                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th><input type="checkbox" id="select_all"></th>
                <th>Product Name</th>
                <th>Customer Name</th>
                <th>Review</th>
                <th>Rating</th>
                <th>Customer Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    @csrf
                    <td><input type="checkbox" class="emp_checkbox" value="{{$review->id}}" name="id[]"></td>
                    <?php 
                        $products = product::where(['id'=>$review->pid])->get();
                    ?>
                    
                    @foreach($products as $product)
                    <td>{{$product->product_name}}</td>
                    @endforeach
                    
                    <td>{{$review->name}}</td>
                    <td>{{$review->review}}</td>
                    <td>{{$review->rate}}</td>
                    <td>{{$review->email}}</td>
                    <td>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="product_status" data-id="{{$review->id}}" <?php echo $review->status==1 ? 'checked' : null; ?> class="onoffswitch-checkbox toggle-event" id="example-{{$review->id}}">
                                <label class="onoffswitch-label" for="example-{{$review->id}}">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a data-href="{{route('admins.review_delete',['id'=>$review->id])}}" class="btn btn-danger btn-sm delete_records" href="javascript:void(0)"><i class="fa fa-times"></i>&nbsp;Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <form>
                </div>
  
            </div>
        </div>
    </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
   $(document).on('click', '#select_all', function() {          	
		$(".emp_checkbox").prop("checked", this.checked);
		$("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
	});	
	$(document).on('click', '.emp_checkbox', function() {		
		if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
			$('#select_all').prop('checked', true);
		} else {
			$('#select_all').prop('checked', false);
		}
		$("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
	}); 
  
    $('.delete_records').click(function(){
        $(".select2").select2();
        swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            let href=$(this).data('href');
            window.location.href=href;
        }
        });

    });
  
    $(".toggle-event").change(function(){
        
        let status=0;
        let product_id=0;
    
        if($(this).prop("checked") == true){
            //run code
            // alert('checked');
            status=1;
            product_id=$(this).data('id');
            console.log(product_id);
           
        }else{
           //run code
            // alert('un checked');
            status=0;
            product_id=$(this).data('id');
            console.log(product_id);
        
        }
        
        updateStatus(status,product_id);
    });
      
      function updateStatus(status,product_id)
      {
            if(product_id>0){
                $.ajax({
                    headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                        },
                    url : "{{route('admins.update_review_status')}}",
                    type : "POST",
                    data : {
                        review_id : product_id,
                        Status : status,
                    },
                    success : function(response){
                        showToastr(response.msg,response.msg_type);
                    }
                });
            }
      }
    //   $(document).ready(function(){
    //       let status=0;
    //       let product_id=0;
    //       $('.swithch').change(function(){
    //         if($(this).is(':checked')){
    //             status=1;
    //             product_id=$(this).data('id');
    //             console.log(product_id);
    //         }else{
    //             status=0;
    //             product_id=$(this).data('id');
    //             console.log(product_id);
    //         }
    //         updateStatus(status,product_id);
    //       });
    //   });
  </script>
@endpush