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
                                    <h2 class="about__h2">YOUR ORDER HAS BEEN PLACED SUCCESSFULLY!</h2>
                                    <div class="about__p-wrap">
                                        <p class="about__p">Your Order ID is {{ Session::get('order_id') }} and Grand Total is INR {{ Session::get('grand_total') }}</p>
                                    </div>

                                    @if(!empty($_GET['order'])&&$_GET['order']=="check")
                                        <div class="about__p-wrap">
                                            <p class="about__p">Please send your Check of amount INR {{ Session::get('grand_total') }} to below Address:<br>
                                                SiteMakers.in<br>
                                                CP, New Delhi<br>
                                                Delhi<br>
                                                India<br>
                                            Check Name: SiteMakers
                                            </p>
                                        </div>
                                    @endif

                                    @if(!empty($_GET['order'])&&$_GET['order']=="bank")
                                        <div class="about__p-wrap">
                                            <p class="about__p">Please transfer amount INR {{ Session::get('grand_total') }} to below Bank Account:<br>
                                                Account Holder Name: SiteMakers<br>
                                                Bank Name: ICICI<br>
                                                IFSC Code: 2425363646<br>
                                            </p>
                                        </div>
                                    @endif

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