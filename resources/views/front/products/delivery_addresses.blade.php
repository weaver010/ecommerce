<?php //dd($deliveryAddresses); ?>
@if(count($deliveryAddresses)>0)
    <h1 class="checkout-f__h1">DELIVERY ADDRESSES</h1>
    <div class="o-summary__section u-s-m-b-30">
        <div class="o-summary__box">
            @foreach($deliveryAddresses as $address)
            <div class="ship-b__box u-s-m-b-10">
                <input class="setDefaultAddress" type="radio" id="address{{ $address['_id'] }}" name="addressid" value="{{ $address['_id'] }}" data-addressid="{{ $address['_id'] }}" @if(isset($address['is_default'])&&$address['is_default']==1) checked @endif>
                <p class="ship-b__p">{{ $address['name'] }},{{ $address['address'] }},{{ $address['city'] }},{{ $address['state'] }},{{ $address['country'] }}</p>

                <a class="ship-b__edit btn--e-transparent-platinum-b-2 editAddress" data-modal="modal" data-modal-id="#edit-ship-address" href="javascript:;" data-addressid="{{ $address['_id'] }}">Edit</a>
                <a class="ship-b__edit btn--e-transparent-platinum-b-2 removeAddress" data-modal="modal" data-modal-id="#edit-ship-address" href="javascript:;" data-addressid="{{ $address['_id'] }}">Delete</a>
            </div>
        @endforeach 
        </div>
    </div>
@endif