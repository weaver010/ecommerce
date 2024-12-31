<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category;
        $category->parent_id = NULL;
        $category->category_name = "Clothing";
        $category->category_image = "";
        $category->category_discount = 0;
        $category->description = "";
        $category->url = "clothing";
        $category->meta_title = "";
        $category->meta_description = "";
        $category->meta_keywords = "";
        $category->status = 1;
        $category->save();

        $subcategory = new Category;
        $subcategory->parent_id = $category->id;
        $subcategory->category_name = "Men";
        $subcategory->category_image = "";
        $subcategory->category_discount = 0;
        $subcategory->description = "";
        $subcategory->url = "men";
        $subcategory->meta_title = "";
        $subcategory->meta_description = "";
        $subcategory->meta_keywords = "";
        $subcategory->status = 1;
        $subcategory->save();

        $subsubcategory = new Category;
        $subsubcategory->parent_id = $subcategory->id;
        $subsubcategory->category_name = "T-Shirts";
        $subsubcategory->category_image = "";
        $subsubcategory->category_discount = 0;
        $subsubcategory->description = "";
        $subsubcategory->url = "tshirts";
        $subsubcategory->meta_title = "";
        $subsubcategory->meta_description = "";
        $subsubcategory->meta_keywords = "";
        $subsubcategory->status = 1;
        $subsubcategory->save();

        $brand = new Brand;
        $brand->brand_name = "Arrow";
        $brand->brand_image = "";
        $brand->brand_logo = "";
        $brand->brand_discount = 0;
        $brand->description = "";
        $brand->url = "arrow";
        $brand->meta_title = "";
        $brand->meta_description = "";
        $brand->meta_keywords = "";
        $brand->status = 1;
        $brand->save();

        $product = new Product;
        $product->category_id = $subsubcategory->id;
        $product->brand_id = $brand->id;
        $product->product_name = 'Blue T-Shirt';
        $product->product_code = 'BT001';
        $product->product_color = 'Dark Blue';
        $product->family_color = 'Blue';
        $product->group_code = 'BT000';
        $product->product_price = 1500;
        $product->product_discount = 10;
        $product->discount_type = 'product';
        $product->final_price = 1350;
        $product->product_weight = 500;
        $product->product_video = '';
        $product->description = 'Test Product';
        $product->wash_care = '';
        $product->search_keywords = '';
        $product->fabric = '';
        $product->pattern = '';
        $product->sleeve = '';
        $product->fit = '';
        $product->occasion = '';
        $product->meta_title = '';
        $product->meta_description = '';
        $product->meta_keywords = '';
        $product->is_featured = 'No';
        $product->status = 1;
        $product->save();

        $product = new Product;
        $product->category_id = $subsubcategory->id;
        $product->brand_id = $brand->id;
        $product->product_name = 'Red T-Shirt';
        $product->product_code = 'R001';
        $product->product_color = 'Red';
        $product->family_color = 'Red';
        $product->group_code = 'BT000';
        $product->product_price = 2000;
        $product->product_discount = 0;
        $product->discount_type = '';
        $product->final_price = 2000;
        $product->product_weight = 400;
        $product->product_video = '';
        $product->description = 'Test Product';
        $product->wash_care = '';
        $product->search_keywords = '';
        $product->fabric = '';
        $product->pattern = '';
        $product->sleeve = '';
        $product->fit = '';
        $product->occasion = '';
        $product->meta_title = '';
        $product->meta_description = '';
        $product->meta_keywords = '';
        $product->is_featured = 'Yes';
        $product->status = 1;
        $product->save();

        $category = new Category;
        $category->parent_id = NULL;
        $category->category_name = "Electronics";
        $category->category_image = "";
        $category->category_discount = 0;
        $category->description = "";
        $category->url = "electronics";
        $category->meta_title = "";
        $category->meta_description = "";
        $category->meta_keywords = "";
        $category->status = 1;
        $category->save();

        $category = new Category;
        $category->parent_id = NULL;
        $category->category_name = "Appliances";
        $category->category_image = "";
        $category->category_discount = 0;
        $category->description = "";
        $category->url = "appliances";
        $category->meta_title = "";
        $category->meta_description = "";
        $category->meta_keywords = "";
        $category->status = 1;
        $category->save();
    }
}
