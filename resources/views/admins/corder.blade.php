
<style>
    td{
        vertical-align: middle !important;
    }
    td img{
        width: 50px;
    }
</style>
@extends('admins.master')

@section('title','Orders')
@section('order','active')
@section('orderc1','collapse in')
@section('corder','active')

<?php
use App\Models\Admins\Product; 
use App\Models\Admins\Order;
?>

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>NEW Orders List</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('admins.bulk_update_status') }}">
                            @csrf

                            <select name="status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Confirmed</option>
                                <option value="2">Delivered</option>
                                <option value="3">Canceled</option>
                                <option value="4">Dispatched</option>
                            </select><br>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-refresh"></i> Update Selected Status
                            </button>

                            {{-- <button type="submit" class="btn btn-danger btn-sm "><i class="fa fa-times"></i>Delete Selected</button> --}}

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select_all"></th>
                                            <th>Sr.No</th>
                                            <th>Order No#</th>
                                            <!--<th>Product Name</th>-->
                                            <th>Customer Name</th>
                                            <th>Customer Status</th>
                                            <!--<th>Customer Phone</th>-->
                                            <th>Payment Status</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Total Price</th>
                                            <!--<th>City</th>-->
                                            <!--<th>Country</th>-->
                                            <!-- <th>Order Date</th> -->
                                            <th>Order DateTime</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($orders as $product)
                                            @if (
                                                ($product->payment_method == 'ngenius' && $product->payment_status == 'Paid') ||
                                                    $product->payment_status == 'CAPTURED' ||
                                                    $product->payment_method != 'ngenius')
                                                <tr>
                                                    @csrf
                                                    <td><input type="checkbox" class="emp_checkbox"
                                                            value="{{ $product->id }}" name="id[]"></td>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $product->order_no }}</td>

                                                    <td>{{ $product->customer_name }}</td>
                                                    <td>
                                                        @php
                                                            $firstOrder = Order::where('email', $product->email)->orderBy('id', 'asc')->first();
                                                            $customerStatus = ($product->id == $firstOrder->id) ? 'New' : 'Returning';
                                                        @endphp
                                                        {{ $customerStatus }}
                                                    </td>
                                                    <td>{{ $product->payment_status == 'CAPTURED' ? 'Paid' : ucfirst($product->payment_status) }}
                                                    </td>
                                                    <td>{{ ucfirst($product->payment_method) }}</td>
                                                    @if ($product->dstatus == 0)
                                                        <td>Pending</td>
                                                    @elseif($product->dstatus == 1)
                                                        <td>Confirmed</td>
                                                    @elseif($product->dstatus == 2)
                                                        <td>Delivered</td>
                                                    @elseif($product->dstatus == 3)
                                                        <td>Canceled</td>
                                                    @elseif($product->dstatus == 4)
                                                        <td>Dispatched</td>
                                                    @endif
                                                    <td>{{ $product->amount }}</td>
                                                    <!-- <td>{{ date('F d Y', strtotime($product->created_at)) }}</td> -->
                                                    @php
                                                        $orderTime = \Carbon\Carbon::parse(
                                                            $product->created_at,
                                                        )->setTimezone('Asia/Dubai');
                                                    @endphp
                                                    <td>{{ $orderTime }}</td>
                                                    <td><a href="{{ route('admins.edit_order', ['id' => $product->id]) }}"
                                                            class="btn btn-primary btn-sm "><i class="fa fa-edit"></i></a>
                                                        <a data-href="{{ route('admins.order_delete', ['id' => $product->id]) }}"
                                                            class="btn btn-danger btn-sm delete_record"
                                                            href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                                    </td>


                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
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