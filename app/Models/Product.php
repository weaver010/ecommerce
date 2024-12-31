<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Model;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','_id')->with('parentcategory');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id','_id');
    }

    public static function productFilters(){
        // Product Filters
        $productFilters['fabricArray'] = array('Cotton','Polyester','Wool');
        $productFilters['sleeveArray'] = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $productFilters['patternArray'] = array('Checked','Plain','Printed','Self','Solid');
        $productFilters['fitArray'] = array('Regular','Slim');
        $productFilters['occasionArray'] = array('Casual','Formal');
        return $productFilters;
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function attributes_front(){
        return $this->hasMany('App\Models\ProductsAttribute')->where('status',1);
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public static function getAttributePrice($product_id,$size){
        $attributePrice = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        // For Getting Product Discount
        $productDetails = Product::select(['product_discount','category_id','brand_id'])->where('_id',$product_id)->first()->toArray();
        // For Getting Category Discount
        $categoryDetails = Category::select(['category_discount'])->where('_id',$productDetails['category_id'])->first()->toArray();
        // For Getting Brand Discount
        $brandDetails = Brand::select(['brand_discount'])->where('_id',$productDetails['brand_id'])->first()->toArray();

        if($productDetails['product_discount']>0){
            // 1st case if there is any Product Discount
            $discount = $attributePrice['price']*$productDetails['product_discount']/100;
            $discount_percent = $productDetails['product_discount'];
            $final_price = $attributePrice['price'] - $discount;
        }else if($categoryDetails['category_discount']>0){
            // 2nd case if there is any Category Discount
            $discount = $attributePrice['price']*$categoryDetails['category_discount']/100;
            $discount_percent = $productDetails['category_discount'];
            $final_price = $attributePrice['price'] - $discount;
        }else if($brandDetails['brand_discount']>0){
            // 3rd case if there is any Brand Discount
            $discount = $attributePrice['price']*$brandDetails['brand_discount']/100;
            $discount_percent = $productDetails['brand_discount'];
            $final_price = $attributePrice['price'] - $discount;
        }else{
            // If there is no discount
            $discount = 0;
            $discount_percent = 0;
            $final_price = $attributePrice['price'];
        }
        return array('product_price'=>$attributePrice['price'],'final_price'=>$final_price,'discount'=>$discount,'discount_percent'=>$discount_percent);
    }

    public static function productStatus($proid){
        $productStatus = Product::select('status')->where('_id',$proid)->first();
        return $productStatus->status;
    }

    public static function getProductImage($product_id){
        $image = "";
        $productImageCount = ProductsImage::select('image')->where('product_id',$product_id)->count();
        if($productImageCount){
            $getProductImage = ProductsImage::select('image')->where('product_id',$product_id)->orderBy('image_sort','desc')->first();
            $image = $getProductImage->image;  
        }
        return $image;
    }

}
