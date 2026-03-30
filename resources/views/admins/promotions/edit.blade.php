@extends('admins.master')

@section('title', 'Edit Promotion')

@section('promotion_active', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Promotion</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('admins.promotions.update', $promotion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $promotion->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" id="promotionType" class="form-control" required>
                                <option value="amount" {{ $promotion->type == 'amount' ? 'selected' : '' }}>Amount</option>
                                <option value="percentage" {{ $promotion->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="item" {{ $promotion->type == 'item' ? 'selected' : '' }}>Free Item</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="discountField">
                            <label>Discount</label>
                            <input type="number" name="discount" class="form-control" value="{{ $promotion->discount }}">
                        </div>
                        
                        <div class="form-group" id="freeProductField" style="display: {{ $promotion->type == 'item' ? 'block' : 'none' }};">
                            <label>Select Free Products</label>
                            <select name="products[]" class="form-control js-example-basic-multiple" multiple>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ in_array($product->id, json_decode($promotion->product_ids, true) ?? []) ? 'selected' : '' }}>
                                        {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Cart Minimum</label>
                            <input type="number" name="cart_minimum" class="form-control" value="{{ $promotion->cart_minimum }}" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ $promotion->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$promotion->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Promotion</button>
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
