<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Model;

class Category extends Model
{
    use HasFactory;

    public function parentcategory(){
        return $this->hasOne('App\Models\Category','_id','parent_id')->select('_id','category_name','url')->orderby('id','ASC')->where('status',1);
    }

    public function subcategories(){
        return $this->hasMany('App\Models\Category','parent_id')->select('_id','category_name','parent_id','url')->where('status',1);
    }

    public static function getcategories(){
        $getcategories = Category::with(['subcategories'=>function($query){
            $query->with('subcategories');
        }])->where('parent_id',NULL)->where('status',1)->get()->toArray();
        return $getcategories;
    }   

    public static function categoryDetails($url){
        $categoryDetails = Category::select('_id','parent_id','category_name','url')->with(['subcategories'=>function($query){
            $query->with('subcategories');
        }])->where('url',$url)->first()->toArray();
        /*echo "<pre>"; print_r($categoryDetails); die;*/
        $catIds =array();
        $catIds[] = $categoryDetails['_id'];
        foreach($categoryDetails['subcategories'] as $subcat){
            $catIds[] = $subcat['_id'];
            foreach($subcat['subcategories'] as $subsubcat){
                $catIds[] = $subsubcat['_id'];
            }
        }

        if($categoryDetails['parent_id']==0){
            // Only Show Main Category in Breadcrumb
            $breadcrumbs = '<a class="gl-tag btn--e-brand-shadow" href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }else{
            // Show Main and Sub Category in Breadcrumb
            $parentCategory = Category::select('category_name','url')->where('_id',$categoryDetails['parent_id'])->first()->toArray();

            $breadcrumbs = '<a class="gl-tag btn--e-brand-shadow" href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a> <a class="gl-tag btn--e-brand-shadow" href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }

        $resp = array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
        return $resp;
    }
}
