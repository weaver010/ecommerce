<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){
        // Get Home Page Slider Banners
        $homeSliderBanners = Banner::where('type','Slider')->orderby('sort','ASC')->where('status',1)->get()->toArray();

        // Get Home Page Fix Banners
        $homeFixBanners = Banner::where('type','Fix')->orderby('sort','ASC')->where('status',1)->get()->toArray();

        // Get New Products
        $newProducts = Product::with(['brand','images'])->orderBy('id','desc')->where('status',1)->limit(4)->get()->toArray();
        //dd($newProducts);

        // Get Best Seller Products
        $bestSellers = Product::with(['brand','images'])->where(['is_bestseller'=>'Yes','status'=>1])->limit(4)->get()->toArray();

        // Get Discounted Products
        $discountedProducts = Product::with(['brand','images'])->where('product_discount','>',0)->where('status',1)->limit(4)->get()->toArray();

        // Get Featured Products
        $featuredProducts = Product::with(['brand','images'])->where(['is_featured'=>'Yes','status'=>1])->limit(4)->get()->toArray();

        return view('front.index')->with(compact('homeSliderBanners','homeFixBanners','newProducts','bestSellers','discountedProducts','featuredProducts'));
    }
}
