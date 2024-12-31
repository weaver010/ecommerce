<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminsRole;

class AdminsRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords = [
                ['subadmin_id'=>'662135e6b4ce0f179a0127a2','module'=>'cms_pages','view_access'=>1,'edit_access'=>1,'full_access'=>1],
                ['subadmin_id'=>'6623cf84fbaf1ae05e0334e2','module'=>'cms_pages','view_access'=>1,'edit_access'=>1,'full_access'=>1],
            ];
        AdminsRole::insert($adminRecords);
    }
}
