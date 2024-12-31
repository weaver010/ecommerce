@extends('front.layout.layout')
@section('content')
<!--====== App Content ======-->
<div class="app-content">
  --------
    <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="about">
                            <div class="about__container">
                                <div class="about__info">
                                    <h2 class="about__h2">YOUR PAYMENT HAS BEEN CONFIRMED!</h2>
                                    <div class="about__p-wrap">
                                        <p>Thanks for the payment. We will process your order very soon.</p>
                                        <p>Your order number is {{ Session::get('order_id') }} and total amount paid is INR {{ Session::get('grand_total') }}</p>
                                    </div>

                                    <a class="about__link btn--e-secondary" href="index.html" target="_blank">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
</div>
@endsection
