@extends('admins.master')

@section('title', 'Coupons')

@section('coupon_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Coupon Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post">
                            @csrf
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">Coupon Code</label>
                                <div class="col-lg-12">
                                    <input type="text" required name="code"
                                        value="{{ isset($edit->code) ? $edit->code : '' }}" class="form-control">
                                    @error('code')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">Discount</label>
                                <div class="col-lg-12">
                                    <input type="number" required name="discount"
                                        value="{{ isset($edit->discount) ? $edit->discount : '' }}" class="form-control">
                                    @error('discount')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">Discount Type</label>
                                <div class="col-lg-12">
                                    <select name="type" class="form-control" required>
                                        <option value="amount"
                                            {{ isset($edit->type) && $edit->type == 'amount' ? 'selected' : '' }}>Amount
                                        </option>
                                        <option value="percentage"
                                            {{ isset($edit->type) && $edit->type == 'percentage' ? 'selected' : '' }}>
                                            Percentage</option>
                                    </select>
                                    @error('type')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">Cart Minimum</label>
                                <div class="col-lg-12">
                                    <input type="number" name="cart_minimum" value="{{ isset($edit->cart_minimum) ? $edit->cart_minimum : '' }}" class="form-control" required>
                                    @error('cart_minimum')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">No of coupons</label>
                                <div class="col-lg-12">
                                    <input type="number" name="num_of_coupons" value="{{ isset($edit->num_of_coupons) ? $edit->num_of_coupons : '' }}" class="form-control" required>
                                    @error('num_of_coupons')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">End Date</label>
                                <div class="col-lg-12">
                                    <input type="date" name="end_date" class="form-control" value="{{ isset($edit->end_date) ? $edit->end_date : '' }}" required>
                                    @error('end_date')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group" id="freeProductField">
                                <label class=" control-label" style="margin-left: 15px">Select Free Products</label>
                                <div class="col-lg-12">
                                    <select name="products[]" class="form-control js-example-basic-multiple" multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{isset($edit) && in_array($product->id, json_decode($edit->products, true) ?? []) ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('products')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">One Time Use:</label>
                                <div class="col-lg-12">
                                    <select name="one_time_use" class="form-control" required>
                                        <option value="1"
                                            {{ isset($edit->one_time_use) && $edit->one_time_use == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0"
                                            {{ isset($edit->one_time_use) && $edit->one_time_use == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">Auto Apply:</label>
                                <div class="col-lg-12">
                                    <select name="auto_apply" class="form-control" required>
                                        <option value="1"
                                            {{ isset($edit->auto_apply) && $edit->auto_apply == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0"
                                            {{ isset($edit->auto_apply) && $edit->auto_apply == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('auto_apply')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px">Status:</label>
                                <div class="col-lg-12">
                                    <select name="status" class="form-control" required>
                                        <option value="1"
                                            {{ isset($edit->status) && $edit->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ isset($edit->status) && $edit->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                            @if (isset($edit->id))
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif

                            <div class="form-group">
                                <label class=" control-label" style="margin-left: 15px"></label>
                                <div class="col-lg-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Coupons List</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Coupon Code</th>
                                        <th>Discount</th>
                                        <th>Coupon Applied</th>
                                        <th>No of Coupons</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($coupons as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->discount }} {{ $item->type == 'percentage' ? '%' : '<span class="icon-aed">' . getSetting('currency') . '</span>' }}</td>
                                            <td>{{ $item->no_of_discount }} </td>
                                            <td>{{ $item->num_of_coupons }} </td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.coupon') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.coupon') }}/{{ $item->id }}/{{ 'delete' }}"
                                                    class="btn btn-danger delete_record">Delete</a>
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
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    @endpush
@endsection