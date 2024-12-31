<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerRecords = [
            ['id'=>1,'type'=>'Slider','image'=>'sitemaker-slider-banner-1.png','link'=>'','title'=>'T-Shirts Collection','alt'=>'T-Shirts Collection','sort'=>1,'status'=>1],
            ['id'=>2,'type'=>'Slider','image'=>'sitemaker-slider-banner-2.png','link'=>'','title'=>'Women Collection','alt'=>'Women Collection','sort'=>2,'status'=>1]
        ];

        Banner::insert($bannerRecords);
    }
}
