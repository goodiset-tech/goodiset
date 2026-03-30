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
                        <form class="form-horizontal" id="order_form" method="post"
                            action="{{ url('/admin/order/up_delivery_status') }}" enctype="multipart/form-data">
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
                                    <div class="form-group"><label class="col-sm-12 control-label">Customer
                                            Apartment/Unit/Building:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->unit) ? htmlspecialchars($edit->unit) : null; ?>" required
                                                required class="form-control" name="unit"></div>
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
                                            <select name="company" id="" class="form-control" required>
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
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Payment Method:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" readonly
                                                value="{{ $edit->payment_method }}">
                                        </div>
                                    </div>
                                </div>
                                @if ($edit->payment_method == 'stripe' || $edit->payment_method == 'Card')
                                    <div class="col-sm-4">
                                        <div class="form-group"><label class="col-sm-12 control-label">Payment
                                                Status:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $edit->payment_status }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Payment Transaction
                                            Id:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" readonly
                                                value="{{ $edit->transaction_id }}">
                                        </div>
                                    </div>
                                </div>
                                @if ($edit->payment_method != 'stripe' && $edit->payment_method != 'Card')
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Payment Status:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="payment_status">
                                                    <option value="">Select </option>
                                                    <option value="paid"
                                                        {{ $edit->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                                    </option>
                                                    <option value="unpaid"
                                                        {{ $edit->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                                    </option>
                                                    <option value="refunded"
                                                        {{ $edit->payment_status == 'refunded' ? 'selected' : '' }}>
                                                        Refunded
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Delivery
                                            Status:</label>

                                        <div class="col-sm-12">
                                            <select class="form-control" name="dstatus" id="delivery-status">
                                                <option <?php if ($edit->dstatus == 0) {
                                                    echo 'selected';
                                                } ?> value="0">Pending</option>
                                                <option <?php if ($edit->dstatus == 1) {
                                                    echo 'selected';
                                                } ?> value="1">Confirmed</option>
                                                <option <?php if ($edit->dstatus == 2) {
                                                    echo 'selected';
                                                } ?> value="2">Delivered</option>
                                                <option <?php if ($edit->dstatus == 3) {
                                                    echo 'selected';
                                                } ?> value="3">Cancel</option>
                                                <option <?php if ($edit->dstatus == 4) {
                                                    echo 'selected';
                                                } ?> value="4">Dispatched </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                            <div class="form-group">
                                <div class="col-sm-10"><button class="btn btn-md btn-primary"
                                        type="submit"><strong>Save</strong></button>
                                    <button type="button" class="btn btn-md btn-info share-driver-btn"
                                        data-order-id="{{ $edit->id }}"><strong>Share with Driver</strong></button>
                                    <button type="button" class="btn btn-md btn-success send-email-btn"
                                        data-order-id="{{ $edit->id }}"><strong>Send Email
                                            Confirmation</strong></button>
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
                                    <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ $v->qty * $v->price ?? $product->discount_price }}
                                    </td>
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
                                        <td><span class="icon-aed">{{ getSetting('currency') }}</span>:{{ optional($v)->price ? $v->qty * $v->price : $product->discount_price }}
                                        </td>
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

        $(document).ready(function() {

            $('.share-driver-btn').click(function() {
                let orderId = $(this).data('order-id');

                $.ajax({
                    url: '/admin/generate-driver-token',
                    method: 'POST',
                    data: {
                        order_id: orderId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.token) {
                            let driverUrl = '{{ url('/driver/order') }}/' + response.token;
                            navigator.clipboard.writeText(driverUrl);
                            alert('Driver URL copied to clipboard: ' + driverUrl);
                        }
                    },
                    error: function(xhr) {
                        alert('Error generating driver link');
                    }
                });
            });


            $('.send-email-btn').click(function() {
                let orderId = $(this).data('order-id');

                $.ajax({
                    url: '/admin/send-order-confirmation-email', // You'll need to create this route
                    method: 'POST',
                    data: {
                        order_id: orderId,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // Optional: Show loading state
                        $('.send-email-btn').attr('disabled', true).text('Sending...');
                    },
                    success: function(response) {
                        if (response.success) {
                            swal({
                                title: "Success",
                                text: "Order confirmation email sent successfully!",
                                icon: "success",
                                button: "OK"
                            });
                        } else {
                            swal({
                                title: "Error",
                                text: response.message || "Failed to send email",
                                icon: "error",
                                button: "OK"
                            });
                        }
                    },
                    error: function(xhr) {
                        swal({
                            title: "Error",
                            text: "An error occurred while sending the email",
                            icon: "error",
                            button: "OK"
                        });
                    },
                    complete: function() {
                        // Reset button state
                        $('.send-email-btn').attr('disabled', false).text(
                            'Send Email Confirmation');
                    }
                });
            });


        });
        const paymentMethod = $('input[value="{{ $edit->payment_method }}"]').val().toLowerCase();
        const stripeLink = "https://dashboard.stripe.com"; // Replace with your actual Stripe link
        const $deliveryStatus = $('#delivery-status');
        let previousStatus = $deliveryStatus.val();

        // Handle form submission with SweetAlert v1 (refund message only)
        $('form').on('submit', function(e) {
            const currentStatus = $deliveryStatus.val();

            if (currentStatus === "3" && previousStatus !== "3") { // Only trigger for new "Cancel" selection
                e.preventDefault(); // Prevent immediate submission

                // Determine refund message based on payment method
                let refundMessage = "";
                if (paymentMethod.includes("card") || paymentMethod.includes("stripe")) {
                    refundMessage =
                        "This is a credit/debit card paument.A full refund will be processed to the client. It may take 3-5 days. Verify in Stripe here: " +
                        stripeLink;
                } else if (paymentMethod.includes("google") || paymentMethod.includes("apple")) {
                    refundMessage =
                        "This is a Google or Apple Pay payment.This will cancel the order ONLY. Manually refund via Stripe here: " +
                        stripeLink + ". Update payment status to 'refunded' in CMS.";
                } else {
                    refundMessage = "Refund processing details unavailable for this payment method.";
                }

                // Show refund message with SweetAlert v1
                swal({
                    title: "Order Canceled",
                    text: refundMessage,
                    icon: "info",
                    button: "OK"
                }).then(() => {
                    // After user clicks "OK", update status and submit form
                    previousStatus = currentStatus;
                    $('#order_form').submit();
                });

            }
        });

        $deliveryStatus.on('change', function() {
            const newStatus = $(this).val();
            if (newStatus !== "3") {
                previousStatus = newStatus;
            }
        });
    </script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
