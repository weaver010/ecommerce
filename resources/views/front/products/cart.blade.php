<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!--====== App Content ======-->
<div align="center"><div class="print-error-msg" style="width:70%; text-align: left; font-size: 14px;"></div></div>
<div align="center"><div class="print-success-msg" style="width:70%; text-align: left; font-size: 14px;"></div></div>
<div class="app-content" id="appendCartItems">
    @include('front.products.cart_items')
</div>
<!--====== End - App Content ======-->
@endsection