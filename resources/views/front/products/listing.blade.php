@extends('front.layout.layout')
@section('content')
<style>
    .pagination nav li{
        float: left;
        width: 20px;
        list-style-type: none;
    }
</style>
<!--====== App Content ======-->
<div class="app-content">

    <!--====== Section 1 ======-->
    <div class="u-s-p-y-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    @include('front.products.filters')
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="shop-p">
                        <div class="shop-p__toolbar u-s-m-b-30">
                            <div class="shop-p__meta-wrap u-s-m-b-60">

                                <span class="shop-p__meta-text-1">FOUND {{ count($categoryProducts) }} RESULTS</span>
                                <div class="shop-p__meta-text-2">
                                    <!-- <a class="gl-tag btn--e-brand-shadow" href="#">T-Shirts</a> -->
                                    <?php echo $categoryDetails['breadcrumbs']; ?>
                                </div>
                            </div>
                            <div class="shop-p__tool-style">
                                <div class="tool-style__group u-s-m-b-8">

                                    <span class="js-shop-grid-target is-active">Grid</span>

                                    <span class="js-shop-list-target">List</span></div>
                                    @if(!isset($_REQUEST['product']))
                                        <form name="sortProducts" id="sortProducts">
                                            <input type="hidden" name="url" id="url" value="{{ $url }}">
                                            <select class="select-box select-box--transparent-b-2 getsort" name="sort" id="sort">
                                                <option selected>Select</option>
                                                <option value="lowest_price" @if(isset($_GET['sort']) && $_GET['sort']=="lowest_price") selected="" @endif>Sort By: Lowest Price</option>
                                                <option value="highest_price" @if(isset($_GET['sort']) && $_GET['sort']=="highest_price") selected="" @endif>Sort By: Highest Price</option>
                                                <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest") selected="" @endif>Sort By: Latest Items</option>
                                                <option value="best_selling" @if(isset($_GET['sort']) && $_GET['sort']=="best_selling") selected="" @endif>Sort By: Best Selling</option>
                                                
                                                <option value="featured_items" @if(isset($_GET['sort']) && $_GET['sort']=="featured_items") selected="" @endif>Sort By: Featured Items</option>
                                                <option value="discounted_items" @if(isset($_GET['sort']) && $_GET['sort']=="discounted_items") selected="" @endif>Sort By: Discounted Items</option>
                                            </select>
                                        </form> 
                                    @endif
                            </div>
                        </div>
                        <div class="shop-p__collection">
                            <div class="row is-grid-active" id="appendProducts">
                                @include('front.products.ajax_products_listing')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section 1 ======-->
</div>
<!--====== End - App Content ======-->
@endsection