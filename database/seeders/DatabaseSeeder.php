<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->call(AdminSeeder::class);
        $this->call(KhoaHocSeeder::class);
        $this->call(LopHocSeeder::class);
        $this->call(HocVienDaDangKySeeder::class);
        $this->call(KeyWordSeeder::class);
    }

}
