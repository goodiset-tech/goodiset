@extends('admins.master')

@section('title', 'Create Promotion')

@section('promotion_active', 'active')

@section('content')
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Create Promotion</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('admins.promotions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" id="promotionType" class="form-control" required>
                                <option value="amount">Amount</option>
                                <option value="percentage">Percentage</option>
                                <option value="item">Free Item</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="discountField">
                            <label>Discount</label>
                            <input type="number" name="discount" class="form-control">
                        </div>
                        
                        <div class="form-group" id="freeProductField" style="display: none;">
                            <label>Select Free Products</label>
                            <select name="products[]" class="form-control js-example-basic-multiple" multiple>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Cart Minimum</label>
                            <input type="number" name="cart_minimum" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Customer Type</label>
                            <select name="customer_type" class="form-control" required>
                                <option value="new">New</option>
                                <option value="anyone">Anyone</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Promotion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('promotionType').addEventListener('change', function () {
        if (this.value === 'item') {
            document.getElementById('discountField').style.display = 'none';
            document.getElementById('freeProductField').style.display = 'block';
        } else {
            document.getElementById('discountField').style.display = 'block';
            document.getElementById('freeProductField').style.display = 'none';
        }
    });
</script>
@push('scripts')
    <script>
        $(document).ready(function() {

            $('.js-example-basic-multiple').select2();

        });
    </script>
    @endpush
@endsection
