<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        DB::table('configs')->delete();

        DB::table('configs')->truncate();

        DB::table('configs')->insert([
            [
                'time'          =>  1000,
                'account'       =>  8000,
                'key'           =>  'DZFullStack',
            ]
        ]);
    }
}
