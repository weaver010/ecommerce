<?php 
use App\Models\Category;
// Get Categories and their Sub Categories
$categories = Category::getCategories();
/*echo "<pre>"; print_r($categories); die;*/
$totalCartItems = totalCartItems();
?>
<header class="header--style-1">
    <!--====== Nav 1 ======-->
    <nav class="primary-nav primary-nav-wrapper--border">
        <div class="container">
            <!--====== Primary Nav ======-->
            <div class="primary-nav">
                <!--====== Main Logo ======-->
                <a class="main-logo" href="index.html">
                <img src="{{ asset('front/images/logo/logo-1.png') }}" alt=""></a>
                <!--====== End - Main Logo ======-->
                <!--====== Search Form ======-->
                <form class="main-form" action="{{ url('/search-products') }}">
                    <label for="main-search"></label>
                    <input name="product" class="input-text input-text--border-radius input-text--style-1" type="text" id="main-search" placeholder="Search">
                    <button class="btn btn--icon fas fa-search main-search-button" type="submit"></button>
                </form>
                <!--====== End - Search Form ======-->
                <!--====== Dropdown Main plugin ======-->
                <div class="menu-init" id="navigation">
                    <button class="btn btn--icon toggle-button toggle-button--secondary fas fa-cogs" type="button"></button>
                    <!--====== Menu ======-->
                    <div class="ah-lg-mode">
                        <span class="ah-close">✕ Close</span>
                        <!--====== List ======-->
                        <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                            <li class="has-dropdown" data-tooltip="tooltip" data-placement="left" title="Account">
                                <a><i class="far fa-user-circle"></i></a>
                                <!--====== Dropdown ======-->
                                <span class="js-menu-toggle"></span>
                                <ul style="width:120px">
                                @if(Auth::check())
                                    <li>
                                        <a href="{{ url('user/account')}}"><i class="fas fa-user-circle u-s-m-r-6"></i>
                                        <span>Account</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('user/logout')}}"><i class="fas fa-lock-open u-s-m-r-6"></i>
                                        <span>Signout</span></a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ url('user/register')}}"><i class="fas fa-user-plus u-s-m-r-6"></i>
                                        <span>Signup</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('user/login')}}"><i class="fas fa-lock u-s-m-r-6"></i>
                                        <span>Signin</span></a>
                                    </li>
                                @endif
                                </ul>
                                <!--====== End - Dropdown ======-->
                            </li>
                            <li data-tooltip="tooltip" data-placement="left" title="Contact">
                                <a href="tel:+0900000000"><i class="fas fa-phone-volume"></i></a>
                            </li>
                            <li data-tooltip="tooltip" data-placement="left" title="Mail">
                                <a href="mailto:contact@domain.com"><i class="far fa-envelope"></i></a>
                            </li>
                        </ul>
                        <!--====== End - List ======-->
                    </div>
                    <!--====== End - Menu ======-->
                </div>
                <!--====== End - Dropdown Main plugin ======-->
            </div>
            <!--====== End - Primary Nav ======-->
        </div>
    </nav>
    <!--====== End - Nav 1 ======-->
    <!--====== Nav 2 ======-->
    <nav class="secondary-nav-wrapper">
        <div class="container">
            <!--====== Secondary Nav ======-->
            <div class="secondary-nav">
                <!--====== Dropdown Main plugin ======-->
                <div class="menu-init" id="navigation2">
                    <button class="btn btn--icon toggle-button toggle-button--secondary fas fa-cog" type="button"></button>
                    <!--====== Menu ======-->
                    <div class="ah-lg-mode">
                        <span class="ah-close">✕ Close</span>
                        <!--====== List ======-->
                        <ul class="ah-list ah-list--design2 ah-list--link-color-secondary">
                            <li>
                                <a href="shop-side-version-2.html">NEW ARRIVALS</a>
                            </li>
                            @foreach($categories as $category)
                            <li class="has-dropdown">
                                <a href="{{url($category['url'])}}">{{$category['category_name']}}
                                <i @if(count($category['subcategories'])>0) class="fas fa-angle-down u-s-m-l-6" @endif></i></a>
                                @if(count($category['subcategories'])>0)
                                <!--====== Dropdown ======-->
                                <span class="js-menu-toggle"></span>
                                <ul style="width:170px">
                                    @foreach($category['subcategories'] as $subcategory)
                                    <li class="has-dropdown has-dropdown--ul-left-100">
                                        <a href="{{url($subcategory['url'])}}">{{$subcategory['category_name']}}<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>
                                        @if(count($subcategory['subcategories'])>0)
                                        <!--====== Dropdown ======-->
                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:118px">
                                            @foreach($subcategory['subcategories'] as $subsubcategory)
                                            <li>
                                                <a href="{{url($subsubcategory['url'])}}">{{$subsubcategory['category_name']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                <!--====== End - Dropdown ======-->
                                @endif
                            </li>
                            @endforeach
                            <li>
                                <a href="listing.html">FEATURED PRODUCTS</a>
                            </li>
                        </ul>
                        <!--====== End - List ======-->
                    </div>
                    <!--====== End - Menu ======-->
                </div>
                <!--====== End - Dropdown Main plugin ======-->
                <!--====== Dropdown Main plugin ======-->
                <div class="menu-init" id="navigation3">
                    <button class="btn btn--icon toggle-button toggle-button--secondary fas fa-shopping-bag toggle-button-shop" type="button"></button>
                    <span class="total-item-round totalCartItems">{{$totalCartItems}}</span>
                    <!--====== Menu ======-->
                    <div class="ah-lg-mode">
                        <span class="ah-close">✕ Close</span>
                        <!--====== List ======-->
                        <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                            <li>
                                <a href="index.html"><i class="fas fa-home u-c-brand"></i></a>
                            </li>
                            <li>
                                <a href="wishlist.html"><i class="far fa-heart"></i></a>
                            </li>
                            <li class="has-dropdown">
                                <a class="mini-cart-shop-link"><i class="fas fa-shopping-bag"></i>
                                <span class="total-item-round totalCartItems">{{$totalCartItems}}</span></a>
                                <!--====== Dropdown ======-->
                                <span class="js-menu-toggle"></span>
                                <div class="mini-cart" id="appendMiniCart">
                                    @include('front.products.mini_cart')
                                </div>
                                <!--====== End - Dropdown ======-->
                            </li>
                        </ul>
                        <!--====== End - List ======-->
                    </div>
                    <!--====== End - Menu ======-->
                </div>
                <!--====== End - Dropdown Main plugin ======-->
            </div>
            <!--====== End - Secondary Nav ======-->
        </div>
    </nav>
    <!--====== End - Nav 2 ======-->
</header>