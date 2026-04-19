@foreach ($products as $product)
    {{-- Full-width cards on phones; 2+ columns from sm breakpoint up --}}
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <x-product-card :product="$product" />
    </div>
@endforeach
