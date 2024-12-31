<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $couponRecords = [
            ['coupon_option'=>'Manual','coupon_code'=>'test10','categories'=>'1','users'=>'','coupon_type'=>'Single','amount_type'=>'Percentage','amount'=>'10','expiry_date'=>'2020-12-31','status'=>1],
            ['coupon_option'=>'Manual','coupon_code'=>'test20','categories'=>'1','users'=>'amit100@yopmail.com','coupon_type'=>'Single','amount_type'=>'Percentage','amount'=>'10','expiry_date'=>'2020-12-31','status'=>1]
        ];

        Coupon::insert($couponRecords);
    }
}
