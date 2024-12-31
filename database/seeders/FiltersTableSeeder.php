<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFilter;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filterRecords = [
            ['filter_name'=>'Fabric','filter_value'=>'Cotton','sort'=>1,'status'=>1],
            ['filter_name'=>'Fabric','filter_value'=>'Polyester','sort'=>2,'status'=>1], 
            ['filter_name'=>'Fabric','filter_value'=>'Wool','sort'=>3,'status'=>1],       
            ['filter_name'=>'Sleeve','filter_value'=>'Full Sleeve','sort'=>1,'status'=>1], 
            ['filter_name'=>'Sleeve','filter_value'=>'Half Sleeve','sort'=>1,'status'=>1], 
        ];

        ProductsFilter::insert($filterRecords);
    }
}
