<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Model;
use Illuminate\Support\Arr;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getColors($catIds){
        $getProductIds = Product::select('_id')->whereIn('category_id',$catIds)->pluck('_id')->toArray();
        $getProductColors = Product::select('family_color')->whereIn('_id',$getProductIds)->groupBy('family_color')->pluck('family_color')->toArray();
        /*echo "<pre>"; print_r($getProductColors); die;*/
        return $getProductColors;
    }

    public static function getSizes($catIds){
        $getProductIds = Product::select('_id')->whereIn('category_id',$catIds)->pluck('_id')->toArray();
        $getProductSizes = ProductsAttribute::select('size')->where('status',1)->wherein('product_id',$getProductIds)->groupby('size')->pluck('size');
        //dd($getProductSizes); die;
        return $getProductSizes;
    }

    public static function getBrands($catIds){
        $getProductIds = Product::select('_id')->whereIn('category_id',$catIds)->pluck('_id');
        $getProductBrandIds = Product::select('brand_id')->whereIn('_id',$getProductIds)->groupBy('brand_id')->pluck('brand_id');
        $getProductBrands = Brand:: select('_id','brand_name')->where('status',1)->wherein('_id',$getProductBrandIds)->orderby('brand_name','ASC')->get()->toArray();
        //dd($getProductBrands);
        return $getProductBrands;
    }

    public static function getfilters($catIds){
        $getProductIds = Product::select('_id')->whereIn('category_id',$catIds)->pluck('_id')->toArray();

        $getFilterColumns = ProductsFilter::select('filter_name')->pluck('filter_name')->toArray();
        foreach ($getFilterColumns as $key => $column) {
            $columns[] = strtolower($column);
        }

        if(count($getFilterColumns)>0){
            $getFilterValues = Product::select($columns)->wherein('_id',$getProductIds)->where('status',1)->get()->toArray();
        }else{
            $getFilterValues = Product::wherein('_id',$getProductIds)->where('status',1)->get()->toArray(); 
        }
        foreach ($getFilterValues as $key => $value) {
            unset($getFilterValues[$key]['_id']);
        }

        //dd($getFilterValues);

        $getFilterValues = array_filter(array_unique(Arr::flatten($getFilterValues)));
        //echo "<pre>"; print_r($getFilterValues); die;

        $getCategoryFilterColumns = ProductsFilter::select('filter_name')->whereIn('filter_value',$getFilterValues)->groupBy('filter_name')->orderby('sort','asc')->where('status',1)->pluck('filter_name')->toArray();
        //echo "<pre>"; print_r($getCategoryFilterColumns); die;
        return $getCategoryFilterColumns;
    }

    public static function selectedFilters($filter_name,$catIds){
        $productFilters = Product::select(strtolower($filter_name))->wherein('category_id',$catIds)/*->groupBy($filter_name)*/->get()->toArray();
        //echo "<pre>"; print_r($productFilters); die;
        foreach ($productFilters as $key => $filter) {
            unset($productFilters[$key]['_id']);
        }
        $productFilters = array_filter(array_unique(Arr::flatten($productFilters)));
        //echo "<pre>"; print_r($productFilters); die;
        return $productFilters;
    }

    public static function filterTypes(){
        $filterTypes = ProductsFilter::select('filter_name')->groupBy('filter_name')->where('status',1)->get()->toArray();
        $filterTypes = Arr::flatten($filterTypes);
        return $filterTypes;
    }

}
