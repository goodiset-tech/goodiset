@extends('admins.master')



<?php

use App\Models\Admins\Size;
use App\Models\Admins\Colors;
use App\Models\Admins\Shap;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Product;
use App\Models\BoxCustomize;
use App\Models\BoxSize;
use App\Models\PackageType;

?>
<style>
    .preview-images-zone {
        width: 100%;
        border: 1px solid #ddd;
        min-height: 180px;
        /* display: flex; */
        padding: 5px 5px 0px 5px;
        position: relative;
        overflow: auto;
    }

    .preview-images-zone>.preview-image:first-child {
        height: 185px;
        width: 185px;
        position: relative;
        margin-right: 5px;
    }

    .preview-images-zone>.preview-image {
        height: 90px;
        width: 90px;
        position: relative;
        margin-right: 5px;
        float: left;
        margin-bottom: 5px;
    }

    .preview-images-zone>.preview-image>.image-zone {
        width: 100%;
        height: 100%;
    }

    .preview-images-zone>.preview-image>.image-zone>img {
        width: 100%;
        height: 100%;
    }

    .preview-images-zone>.preview-image>.tools-edit-image {
        position: absolute;
        z-index: 100;
        color: #fff;
        bottom: 0;
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
        display: none;
    }

    .preview-images-zone>.preview-image>.image-cancel {
        font-size: 18px;
        position: absolute;
        top: 0;
        right: 0;
        font-weight: bold;
        margin-right: 10px;
        cursor: pointer;
        display: none;
        z-index: 100;
    }

    .preview-image:hover>.image-zone {
        cursor: move;
        opacity: .5;
    }

    .preview-image:hover>.tools-edit-image,
    .preview-image:hover>.image-cancel {
        display: block;
    }

    .ui-sortable-helper {
        width: 90px !important;
        height: 90px !important;
    }

    .container {
        padding-top: 50px;
    }

    label {
        text-align: left !important;
    }

    .bootstrap-tagsinput {
        width: 100% !important;
    }

    span.select2-selection.select2-selection--multiple {
        width: 302px;
    }

    span.select2-dropdown.select2-dropdown--below {
        width: 301px !important;
    }
</style>
@section('title', 'Orders')

@section('order', 'active')



@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Order Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" id="" method="post"
                            action="{{ url('/admin/order/up_draft_status') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $edit->id }}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Customer Name:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->customer_name) ? htmlspecialchars($edit->customer_name) : null; ?>" required
                                                class="form-control" name="customer_name"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Customer Phone:</label>
                                        <div class="col-sm-12"><input type="text" class="form-control" name="phone"
                                                required value="<?php echo isset($edit->phone) ? htmlspecialchars($edit->phone) : null; ?>"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Customer City:</label>
                                        <div class="col-sm-12"><input type="text" class="form-control" required
                                                value="<?php echo isset($edit->city) ? htmlspecialchars($edit->city) : null; ?>" name="city"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Customer Email:</label>
                                        <div class="col-sm-12"><input type="text" class="form-control" required
                                                value="<?php echo isset($edit->email) ? htmlspecialchars($edit->email) : null; ?>" name="email"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Customer Address:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->address) ? htmlspecialchars($edit->address) : null; ?>" required
                                                required class="form-control" name="address"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Customer Country:</label>
                                        <div class="col-sm-12"><input type="text" class="form-control" name="country"
                                                required value="<?php echo isset($edit->country) ? htmlspecialchars($edit->country) : null; ?>"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Shipping Company:</label>

                                        <div class="col-sm-12">
                                            <select name="company" id="" class="form-control">
                                                <option value="">Select</option>
                                                @foreach ($shippingMethods as $v)
                                                    <option value="{{ $v->name }}"
                                                        {{ $edit->shipping_company == $v->name ? 'selected' : '' }}>
                                                        {{ $v->name }}</option>
                                                @endforeach

                                            </select>
                                            {{-- <input type="text" class="form-control"
                                                value="<?php echo isset($edit->shipping_company) ? htmlspecialchars($edit->shipping_company) : null; ?>" name="company"> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Tracking Url:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->track_url) ? htmlspecialchars($edit->track_url) : null; ?>"
                                                class="form-control" name="track_url"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Tracking No:</label>
                                        <div class="col-sm-12"><input type="text" class="form-control" name="track_no"
                                                value="{{ $edit->track_no }}"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group"><label class="col-sm-12 control-label">Note:</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="note" rows="4">{{ $edit->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @php
                                        $orderTime = \Carbon\Carbon::parse($edit->created_at)->setTimezone(
                                            'Asia/Dubai',
                                        );
                                    @endphp
                                    <div class="form-group"><label class="col-sm-12 control-label">Order date:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" readonly
                                                value="{{ $orderTime }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Payment Method:</label>

                                        <div class="col-sm-12">
                                            <select class="form-control" name="payment_method" required>
                                                <option value="">Select </option>
                                                <option value="Google Pay">Google Pay </option>
                                                <option value="Apple Pay">Apple Pay </option>
                                                <option value="Card">Card </option>
                                                <option value="Cash">Cash </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Payment Status:</label>

                                        <div class="col-sm-12">
                                            <select class="form-control" name="payment_status" required>
                                                <option value="">Select </option>
                                                <option value="paid">Paid </option>
                                                <option value="unpaid ">Unpaid </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Delivery
                                            Status:</label>

                                        <div class="col-sm-12">
                                            <select class="form-control" name="dstatus" required>
                                                <option value="">Select status</option>
                                                <option <?php if ($edit->dstatus == 0) {
                                                    echo 'selected';
                                                } ?> value="0">Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                            <div class="form-group">
                                <div class="col-sm-10"><button class="btn btn-md btn-primary"
                                        type="submit"><strong>Save</strong></button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pro = json_decode($edit->product_detail);
                                foreach ($pro as $v) {
                                    if ($v->id != null) {
                                        $product = Product::where(['id' => $v->id])->first();
                                        if ($product) {
                                            
                                        if(isset($product->format) && $product->format == 3){ 
                                ?>
                                <tr class="toggle-row-1" data-id="{{ $edit->id }}" style="cursor: pointer;"
                                    title="Click to see the details.">
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $v->qty }}</td>
                                    <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ optional($v)->price ? $v->qty * $v->price : $product->discount_price }}</td>
                                </tr>
                                <tr class="bundle-details" id="bundle-detail-{{ $edit->id }}"
                                    style="display: none;">
                                    <td colspan="3">
                                        <table class="table table-bordered mt-2">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                 $rpro = [];
                                                    if (isset($product->bundle_product_id)) {
                                                        $rpro = explode(',', $product->bundle_product_id);
                                                    }
                                                    $rprod = Product::whereIn('id', $rpro)->get();
                                                foreach ($rprod as $product) {
                                                ?>
                                                <tr>
                                                    <td>{{ $product->product_name ?? '' }}</td>
                                                    <td>{{ $product->format == 1 ? '100 g' : '1' }}</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <?php
                                        }else{
                                ?>
                                <tr>
                                    <td>{{ $product->product_name ?? '' }}</td>
                                    <td>{{ $v->qty }}</td>
                                    @if (isset($v->name) && $v->name == 'Free Product')
                                        <td>{{ $v->name }}</td>
                                    @else
                                        <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ $v->qty * $v->price ?? $product->discount_price }}</td>
                                    @endif
                                </tr>
                                <?php
                                        }
                                    }
                                }}
                                ?>

                                <?php
                                $pack = json_decode($edit->package_detail);
                                foreach ($pack as $key => $value) {
                                $package = BoxCustomize::where('package_id', $value->package_type)
                                    ->where('size_id', $value->package_size)
                                    ->first();
                                if($package){
                                    $box_size = BoxSize::where('id',$value->package_size)->first();
                                    $PackageType = PackageType::where('id',$value->package_type)->first();
                                ?>
                                <!-- Main Package Row -->
                                <tr class="toggle-row" data-id="{{ $value->package_type }}" style="cursor: pointer;"
                                    title="Click to see the details.">
                                    <td>{{ $PackageType->name }} <span>({{ $box_size->name }})</span></td>
                                    <td>{{ $value->qty }}</td>
                                    <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ $value->qty * $value->package_price }}</td>
                                </tr>

                                <!-- Hidden Package Details Row -->
                                <tr class="package-details" id="details-{{ $value->package_type }}"
                                    style="display: none;">
                                    <td colspan="3">
                                        <table class="table table-bordered mt-2">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $products = json_decode($value->package_products, true);
                                                foreach ($products as $product) {
                                                ?>
                                                <tr>
                                                    <td>{{ $product['name'] }}</td>
                                                    <td>{{ $product['quantity'] }} g</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                            <tfoot>

                                @if ($edit->shipping_fee)
                                    <tr>
                                        <td></td>
                                        <th scope="row">Shipping</th>
                                        <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ $edit->shipping_fee }}</td>
                                    </tr>
                                @endif
                                @if ($edit->vat)
                                    <tr>
                                        <td></td>
                                        <th scope="row">Vat</th>
                                        <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ $edit->vat }}</td>
                                    </tr>
                                @endif
                                @if ($edit->coupon_code)
                                    <tr>
                                        <td></td>
                                        <th scope="row">Coupon Applied</th>
                                        <td>{{ $edit->coupon_code }}</td>
                                    </tr>
                                @endif
                                @if ($edit->discount)
                                    <tr>
                                        <td></td>
                                        <th scope="row">Discount</th>
                                        <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ $edit->discount }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td></td>
                                    <th scope="row">Totals</th>
                                    <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ $edit->amount }}</td>
                                </tr>
                            </tfoot>
                        </table>

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
        document.querySelectorAll('.toggle-row').forEach(row => {
            row.addEventListener('click', () => {
                const detailsId = row.getAttribute('data-id');
                const detailsRow = document.getElementById(`details-${detailsId}`);
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.toggle-row-1').forEach(row => {
            row.addEventListener('click', () => {
                const detailsId = row.getAttribute('data-id');
                const detailsRow = document.getElementById(`bundle-detail-${detailsId}`);
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(input).parent().find('img').attr('src', e.target.result).show();
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function() {
            let sub_cat_id = $('input[name="sub_cat_id"]').val();
            let cat_id = $('select[name="category_id"]').val();
            getSubCats(cat_id, sub_cat_id);
            $('select[name="category_id"]').change(function() {
                getSubCats($(this).val(), 0);
            });

            function getSubCats(cat_id, sub_cat_id) {
                var cid = (cat_id === undefined || cat_id === null) ? '' : String(cat_id).trim();
                if (!cid || cid === 'undefined' || !/^\d+$/.test(cid)) {
                    return;
                }
                $.ajax({
                        url: "{{ route('admins.get_subCategory_html') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: "POST",
                        data: "category_id=" + cid + "&sub_category_id=" + sub_cat_id,
                        success: function(response) {
                            console.log(response);
                            $('select[name="subcategory_id"]').html("").html(response);
                        }
                    });

            }

        });



        $(document).ready(function() {
            $(document).on("submit", "#product_form", function(e) {
                // alert( $('#short_discriiption').summernote('code'));
                $("#short_discriiption").val($('#short_discriiption').summernote('code'));
                $("#product_details").val($('#product_details').summernote('code'));

                return true;
                // e.preventDefault();
            });

            $(document).on("submit", "#product_form", function(e) {
                if ($('#product_details').summernote('codeview.isActivated')) {
                    $('#product_details').summernote('codeview.deactivate');
                }
                if ($('#short_discriiption').summernote('codeview.isActivated')) {
                    $('#short_discriiption').summernote('codeview.deactivate');
                }
            });
            document.getElementById('pro-image').addEventListener('change', readImage, false);

            $(".preview-images-zone").sortable();

            $(document).on('click', '.image-cancel', function() {

                let no = $(this).data('no');

                let image_id = $(this).attr('id');
                console.log(image_id);

                deleteimagevalue = $('#delete_gallary_images').val()
                newdeleteimagevalue = deleteimagevalue + "," + image_id;
                $('#delete_gallary_images').val(newdeleteimagevalue);


                //   var img = $(".preview-image.preview-show-"+no).find('img').attr('src');
                //   console.log(imagevalue);
                //   console.log(img);

                //   let result = imagevalue.includes("_____"+img);
                // //   console.log(result);
                //   if(result){
                //       newimagetext = imagevalue.replace('_____'+img,'');
                //   }else{
                //       let result2 = imagevalue.includes(img+"_____");
                //       if(result2){
                //           newimagetext = imagevalue.replace(img+'_____','');
                //       }

                //   }
                //   console.log(newimagetext);

                //   $('#gallary_images').val(imagevalue);

                $(".preview-image.preview-show-" + no).remove();
                //   console.log($(".preview-image.preview-show-"+no).children().css({"color": "red", "border": "2px solid red"}));

            });
        });


        var num = 0;

        function readImage() {
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files; //FileList object
                var output = $(".preview-images-zone");

                for (let i = 0; i < files.length; i++) {
                    var file = files[i];
                    var checkdiv = $('div.preview-image').length;
                    // lemit line
                    if (num <= 5 || checkdiv <= 5) {

                        var num = checkdiv;
                        if (!file.type.match('image')) continue;

                        var picReader = new FileReader();

                        picReader.addEventListener('load', function(event) {
                            var picFile = event.target;
                            imagevalue = $('#gallary_images').val()
                            addvalue = picFile.result;
                            console.log(picFile.result);
                            newvalue = imagevalue + "_____" + addvalue
                            $('#gallary_images').val(newvalue);
                            var html = '<div class="preview-image preview-show-' + num + '">' +
                                '<div class="image-cancel" data-no="' + num + '">x</div>' +
                                '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result +
                                '"></div>' +
                                '<div class="tools-edit-image"><a href="javascript:void(0)" data-no="' + num +
                                '" class="btn btn-light btn-edit-image">edit</a></div>' +
                                '</div>';

                            output.append(html);
                            num = num + 1;
                        });
                    }
                    picReader.readAsDataURL(file);
                }
                $("#pro-image").val('');
            } else {
                console.log('Browser not support');
            }
        }
    </script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
