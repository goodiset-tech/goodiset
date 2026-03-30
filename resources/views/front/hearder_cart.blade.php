@foreach (App\Helpers\Cart::products() as $product)
  <li>
    <div class="media"> <a class="pull-left"> <img alt="Electrro" src="/{{$product->image_one}}" width="100px"height="100px"></a>
      <div class="media-body"> <span><a>{{$product->product_name}}</a></span>
        <p class="cart-price">Rs {{$product->discount_price}}</p>
        <div class="product-qty">
          <label>Qty:</label>
          <div class="custom-qty">
            <input type="text" name="qty" maxlength="8" value="{{$product['qty']}}" title="Qty" class="input-text qty">
          </div>
        </div>
      </div>
    </div>
  </li>
  @endforeach