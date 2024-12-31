<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Model;

class ProductsAttribute extends Model
{
    use HasFactory;

    public static function productStock($proid,$size){
        $productStock = ProductsAttribute::select('stock')->where(['product_id'=>$proid,'size'=>$size,'status'=>1])->first();
        return $productStock->stock;
    }

    public static function getAttributeSKU($proid,$size){
        $getAttributeSKU = ProductsAttribute::select('sku')->where(['product_id'=>$proid,'size'=>$size,'status'=>1])->first();
        return $getAttributeSKU->sku;
    }
}
