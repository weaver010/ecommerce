<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');

        $adminRecords = [
            ['name'=>'Admin','type'=>'admin','mobile'=>9800000000,'email'=>'admin@admin.com','password'=>$password,'image'=>'','status'=>1],
            ['name'=>'Amit','type'=>'subadmin','mobile'=>9700000000,'email'=>'amit@admin.com','password'=>$password,'image'=>'','status'=>1],
            ['name'=>'John','type'=>'subadmin','mobile'=>9600000000,'email'=>'john@admin.com','password'=>$password,'image'=>'','status'=>1],
        ];
        Admin::insert($adminRecords);
    }
}
