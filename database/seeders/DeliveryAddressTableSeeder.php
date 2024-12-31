<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryRecords = [
            ['user_id'=>'6697db2347bd980ea8069994','name'=>'Amit Gupta','address'=>'Test 1234, Mall Road','city'=>'New Delhi','state'=>'Delhi','country'=>'India','pincode'=>10001,'mobile'=>9800000000,'status'=>1],
            ['user_id'=>'6697db2347bd980ea8069994','name'=>'Steve','address'=>'123456, Mall Road','city'=>'New Delhi','state'=>'Delhi','country'=>'India','pincode'=>10001,'mobile'=>9800000000,'status'=>1]
        ];

        DeliveryAddress::insert($deliveryRecords);
    }
}
