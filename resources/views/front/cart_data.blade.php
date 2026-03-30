@foreach (App\Helpers\Cart::products() as $product)
    <tr>
    <td class="w-25">
    <img src="/{{$product->image_one}}" class="img-fluid img-thumbnail" width="100px"height="100px" alt="Sheep">
    </td>
    <td>{{$product->product_name}}</td>
    <td>Rs {{$product->discount_price}}</td>
    <td class="qty"><input type="text" class="form-control" id="input1" value="{{$product['qty']}}"></td>
    <td>Rs: <?=$product->discount_price * $product['qty']?></td>
    </tr>
@endforeach
