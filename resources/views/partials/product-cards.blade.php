@foreach ($products as $product)
    <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <x-product-card :product="$product" />
    </div>
@endforeach
