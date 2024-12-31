<?php 
use App\Models\Product; 
$getCartItems = getCartItems();
?>
<!--====== Mini Product Container ======-->
<div class="mini-product-container gl-scroll u-s-m-b-15">
    @php $total_price = 0 @endphp
    @foreach($getCartItems as $item)
    <?php $getAttributePrice = Product::getAttributePrice($item['product_id'],$item['product_size']);
    ?>
    <!--====== Card for mini cart ======-->
    <div class="card-mini-product">
        <div class="mini-product">
            <div class="mini-product__image-wrapper">
                <a class="mini-product__link" href="{{ url('product/'.$item['product_id'])}}">
                    @if(isset($item['product']['images'][0]['image']) && !empty($item['product']['images'][0]['image']))  
                        <img class="u-img-fluid" src="{{ asset('front/images/products/small/'.$item['product']['images'][0]['image']) }}" alt="">
                    @else
                        <img class="u-img-fluid" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}" alt="">
                    @endif
                </a>
            </div>
            <div class="mini-product__info-wrapper">
                <span class="mini-product__category">
                <a href="shop-side-version-2.html">{{ $item['product']['brand']['brand_name'] }}</a></span>
                <span class="mini-product__name">
                <a href="product-detail.html">{{ $item['product']['product_name'] }}</a></span>
                <span class="mini-product__quantity">{{ $item['product_qty'] }} x</span>
                <span class="mini-product__price">₹{{ $getAttributePrice['final_price'] }}</span>
            </div>
        </div>
        <a class="mini-product__delete-link far fa-trash-alt deleteCartItem" data-cartid="{{$item['_id']}}"></a>
    </div>
    <!--====== End - Card for mini cart ======-->
    @php $total_price = $total_price + ($getAttributePrice['final_price'] * $item['product_qty']) @endphp
    @endforeach
</div>
<!--====== End - Mini Product Container ======-->
<!--====== Mini Product Statistics ======-->
<div class="mini-product-stat">
    <div class="mini-total">
        <span class="subtotal-text">SUBTOTAL</span>
        <span class="subtotal-value">₹{{ $total_price }}</span>
    </div>
    <div class="mini-action">
        <a class="mini-link btn--e-brand-b-2" href="{{url('checkout')}}">PROCEED TO CHECKOUT</a>
        <a class="mini-link btn--e-transparent-secondary-b-2" href="{{url('cart')}}">VIEW CART</a>
    </div>
</div>
<!--====== End - Mini Product Statistics ======-->