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
                                    <h2 class="about__h2">YOUR ORDER HAS BEEN FAILED!</h2>
                                    <div class="about__p-wrap">
                                        <p class="about__p">Please try again after some time and contact us if there is any enquiry</p>
                                    </div>

                                    <a class="about__link btn--e-secondary" href="{{url('/')}}" >Continue Shopping</a>
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