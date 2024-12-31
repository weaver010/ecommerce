<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatusRecords = [
            ['name'=>'New','status'=>1],
            ['name'=>'Pending','status'=>1],
            ['name'=>'Cancelled','status'=>1],
            ['name'=>'In Process','status'=>1],
            ['name'=>'Shipped','status'=>1],
            ['name'=>'Partially Shipped','status'=>1],
            ['name'=>'Delivered','status'=>1],
            ['name'=>'Partially Delivered','status'=>1],
            ['name'=>'Paid','status'=>1]
        ];

        OrderStatus::insert($orderStatusRecords);
    }
}
