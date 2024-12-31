<?php 
use App\Models\ProductsFilter; 
use App\Models\Category;
$categories = Category::getCategories();
?> 
<div class="shop-w-master">
    <h1 class="shop-w-master__heading u-s-m-b-30"><i class="fas fa-filter u-s-m-r-8"></i>

        <span>FILTERS</span></h1>
        <div class="shop-w-master__sidebar">
            <div class="u-s-m-b-30">
                <div class="shop-w shop-w--style">
                    <div class="shop-w__intro-wrap">
                        <h1 class="shop-w__h">CATEGORY</h1>

                        <span class="fas fa-minus shop-w__toggle" data-target="#s-category" data-toggle="collapse"></span>
                    </div>
                    <div class="shop-w__wrap collapse show" id="s-category">
                        <ul class="shop-w__category-list gl-scroll">
                            @foreach($categories as $category)
                            <li class="has-list">
                                <a href="{{url($category['url'])}}">{{$category['category_name']}}</a>
                                <span class="js-shop-category-span is-expanded fas fa-plus u-s-m-l-6"></span>
                                @if(count($category['subcategories']))
                                <ul style="display:block">
                                    @foreach($category['subcategories'] as $subcategory)
                                    <li class="has-list">
                                        <a href="{{url($subcategory['url'])}}">{{$subcategory['category_name']}}</a>
                                        @if(count($subcategory['subcategories']))
                                        <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                        <ul>
                                            @foreach($subcategory['subcategories'] as $subsubcategory)
                                            <li>
                                                <a href="{{url($subsubcategory['url'])}}">{{$subsubcategory['category_name']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @if(!isset($_REQUEST['product']))
                <div class="u-s-m-b-30">
                    <div class="shop-w shop-w--style">
                        <div class="shop-w__intro-wrap">
                            <h1 class="shop-w__h">SIZE</h1>

                            <span class="fas fa-minus shop-w__toggle" data-target="#s-size" data-toggle="collapse"></span>
                        </div>
                        <div class="shop-w__wrap collapse show" id="s-size">
                            <?php $getSizes = ProductsFilter::getSizes($categoryDetails['catIds']); ?>
                            <ul class="shop-w__list gl-scroll">
                                @foreach($getSizes as $key => $size)
                                <?php
                                  if(isset($_GET['size'])&&!empty($_GET['size'])){
                                           $sizes = explode('~',$_GET['size']);
                                            if(!empty($sizes) && in_array($size, $sizes)){
                                                      $sizechecked = "checked";
                                             }else{
                                                      $sizechecked = "";
                                              }
                                   }else{
                                             $sizechecked = "";
                                  }
                                ?>
                                <li>
                                    <!--====== Check Box ======-->
                                    <div class="check-box">
                                        <input type="checkbox" name="size" id="size{{$key}}" value="{{$size}}" class="filterAjax" {{$sizechecked}}>
                                        <div class="check-box__state check-box__state--primary">
                                            <label class="check-box__label" for="size{{$key}}">{{$size}}</label>
                                        </div>
                                    </div>
                                    <!--====== End - Check Box ======-->
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="u-s-m-b-30">
                    <div class="shop-w shop-w--style">
                        <div class="shop-w__intro-wrap">
                            <h1 class="shop-w__h">BRAND</h1>
                            <span class="fas fa-minus shop-w__toggle" data-target="#s-brand" data-toggle="collapse"></span>
                        </div>
                        <div class="shop-w__wrap collapse show" id="s-brand">
                            <?php $getBrands = ProductsFilter::getBrands($categoryDetails['catIds']); ?>
                            <ul class="shop-w__list gl-scroll">
                                @foreach($getBrands as $key => $brand)
                                <?php
                                    if(isset($_GET['brand'])&&!empty($_GET['brand'])){
                                        $brands = explode('~',$_GET['brand']);
                                            if(!empty($brands) && in_array($brand['brand_name'], $brands)){
                                                $brandchecked = "checked";
                                            }else{
                                                $brandchecked = "";
                                            }
                                        }else{
                                            $brandchecked = "";
                                    }
                                ?>
                                <li>
                                    <!--====== Check Box ======-->
                                    <div class="check-box">
                                        <input type="checkbox" value="{{$brand['brand_name']}}" name="brand" id="brand{{$key}}" class="filterAjax" {{$brandchecked}}>
                                        <div class="check-box__state check-box__state--primary">
                                            <label class="check-box__label" for="brand{{$key}}">{{$brand['brand_name']}}</label>
                                        </div>
                                    </div>
                                    <!--====== End - Check Box ======-->
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="u-s-m-b-30">
                    <div class="shop-w shop-w--style">
                        <div class="shop-w__intro-wrap">
                            <h1 class="shop-w__h">PRICE</h1>

                            <span class="fas fa-minus shop-w__toggle" data-target="#s-price" data-toggle="collapse"></span>
                        </div>
                        <div class="shop-w__wrap collapse show" id="s-price">
                            <?php $prices = array('0-1000','1000-2000','2000-5000','5000-10000','10000-100000'); ?>
                            <ul class="shop-w__list gl-scroll">
                                @foreach($prices as $key => $price)
                                <?php
                                    if(isset($_GET['price'])&&!empty($_GET['price'])){
                                        $prices = explode('~',$_GET['price']);
                                        if(!empty($prices) && in_array($price, $prices)){
                                            $pricechecked = "checked";
                                        }else{
                                            $pricechecked = "";
                                        }
                                     }else{
                                        $pricechecked = "";
                                    }
                                ?>
                                <li>
                                    <!--====== Check Box ======-->
                                    <div class="check-box">
                                        <input type="checkbox" name="price" value="{{ $price }}" id="price{{ $key }}" class="filterAjax" {{$pricechecked}}>
                                        <div class="check-box__state check-box__state--primary">
                                            <label class="check-box__label" for="price{{ $key }}">Rs. {{ $price }}</label></div>
                                    </div>
                                    <!--====== End - Check Box ======-->
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="u-s-m-b-30">
                    <div class="shop-w shop-w--style">
                        <div class="shop-w__intro-wrap">
                            <h1 class="shop-w__h">COLOR</h1>

                            <span class="fas fa-minus shop-w__toggle" data-target="#s-color" data-toggle="collapse"></span>
                        </div>
                        <div class="shop-w__wrap collapse show" id="s-color">
                            <?php $getColors = ProductsFilter::getColors($categoryDetails['catIds']); ?>
                            <ul class="shop-w__list gl-scroll">
                                @foreach($getColors as $key => $color)
                                <?php
                                    if(isset($_GET['color'])&&!empty($_GET['color'])){
                                       $colors = explode('~',$_GET['color']);
                                        if(!empty($colors) && in_array($color, $colors)){
                                            $colorchecked = "checked";
                                        }else{
                                            $colorchecked = "";
                                        }
                                    }else{
                                        $colorchecked = "";
                                    }
                                ?>
                                <li>
                                    <div class="color__check">
                                        <input type="checkbox" name="color" id="color{{$key}}" value="{{$color}}" class="filterAjax" {{$colorchecked}}>
                                        <label class="color__check-label" for="color{{$key}}" style="background-color: {{$color}}" title="{{$color}}"></label></div>{{$color}}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <?php $getfilters = ProductsFilter::getfilters($categoryDetails['catIds']);
                    /*echo "<pre>"; print_r($getfilters); die;*/
                ?>
                @foreach($getfilters as $key => $filter)
                <div class="u-s-m-b-30">
                    <div class="shop-w shop-w--style">
                        <div class="shop-w__intro-wrap">
                            <h1 class="shop-w__h">{{ucwords($filter)}}</h1>
                            <span class="fas fa-minus collapsed shop-w__toggle" data-target="#s-dynamic{{$key}}" data-toggle="collapse"></span>
                        </div>
                        <div class="shop-w__wrap collapse" id="s-dynamic{{$key}}">
                            <ul class="shop-w__list gl-scroll">
                                <?php $filterVals = ProductsFilter::selectedFilters($filter,$categoryDetails['catIds']);
                                /*echo "<pre>"; print_r($filterVals); die;*/
                                ?>
                                @foreach($filterVals as $fvkey=> $filterValue)
                                <?php $checkFilter="";?>
                                  @if(isset($_GET[$filter])) 
                                      <?php $explodeFilters = explode('~',$_GET[$filter]);?>
                                      @if(in_array($filterValue,$explodeFilters))
                                          <?php $checkFilter="checked";?>
                                      @endif
                                  @endif
                                <li>
                                    <!--====== Check Box ======-->
                                    <div class="check-box">
                                        <input type="checkbox" id="filter{{$fvkey}}" name="{{$filter}}" value="{{$filterValue}}" class="filterAjax" {{$checkFilter}}>
                                        <div class="check-box__state check-box__state--primary">
                                            <label class="check-box__label" for="filter{{$fvkey}}">{{$filterValue}}</label></div>
                                    </div>
                                    <!--====== End - Check Box ======-->
                                </li>
                                @endforeach
                     
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

</div>