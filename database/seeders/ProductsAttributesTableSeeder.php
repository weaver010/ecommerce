<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttributesRecords = [
            ['product_id'=>'662dba2ceff4bf2d25088942','sku'=>'BTS001-S','size'=>'Small','price'=>'1500','stock'=>10,'status'=>1],
            ['product_id'=>'662dba2ceff4bf2d25088942','sku'=>'BTS001-M','size'=>'Medium','price'=>'1600','stock'=>20,'status'=>1],
            ['product_id'=>'662dba2ceff4bf2d25088942','sku'=>'BTS001-L','size'=>'Large','price'=>'1700','stock'=>10,'status'=>1]
        ];

        ProductsAttribute::insert($productAttributesRecords);
    }
}
