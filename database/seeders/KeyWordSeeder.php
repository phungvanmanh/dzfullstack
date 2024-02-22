<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('key_words')->delete();

        DB::table('key_words')->truncate();

        DB::table('key_words')->insert([
            ['code' => 'A01', 'keyword' => 'Nhà hàng hải sản Bé Biển Đà Nẵng', 'from' => '1', 'to' => '4',],
            ['code' => 'A02', 'keyword' => 'Hải sản chất lượng Bé Biển Đà Nẵng', 'from' => '4', 'to' => '11',],
            ['code' => 'A03', 'keyword' => 'Địa điểm nhà hàng hải sản Đà Nẵng', 'from' => '11', 'to' => '13',],
            ['code' => 'A04', 'keyword' => 'Quán hải sản đà nẵng', 'from' => '13', 'to' => '17',],
            ['code' => 'A05', 'keyword' => 'Quán hải sản bé biển', 'from' => '17', 'to' => '23',],
            ['code' => 'A06', 'keyword' => 'Hải sản Bé Biển Đà Nẵng', 'from' => 23, 'to' => 29],
            ['code' => 'A07', 'keyword' => 'Hải sản ngon bé biển', 'from' => 29, 'to' => 35],
            ['code' => 'A08', 'keyword' => 'Hải sản ngon đà nẵng bé biển', 'from' => 35, 'to' => 39],
            ['code' => 'A09', 'keyword' => 'restaurant be bien da nang', 'from' => 39, 'to' => 43],
            ['code' => 'A10', 'keyword' => 'restaurant da nang be bien', 'from' => 43, 'to' => 46],
            ['code' => 'A11', 'keyword' => 'seafood be bien', 'from' => 46, 'to' => 52],
            ['code' => 'A12', 'keyword' => 'seafood da nang be bien', 'from' => 52, 'to' => 58],
            ['code' => 'A13', 'keyword' => 'da nang seafood be bien', 'from' => 58, 'to' => 64],
            ['code' => 'A14', 'keyword' => 'Nha hang hai san Be Bien Da Nang', 'from' => 64, 'to' => 67],
            ['code' => 'A15', 'keyword' => 'Hai san chat luong Be Bien Da Nang', 'from' => 67, 'to' => 70],
            ['code' => 'A16', 'keyword' => 'Dia diem nha hang hai san Da Nang', 'from' => 70, 'to' => 73],
            ['code' => 'A17', 'keyword' => 'Quan hai san da nang', 'from' => 73, 'to' => 79],
            ['code' => 'A18', 'keyword' => 'Quan hai san be bien', 'from' => 79, 'to' => 83],
            ['code' => 'A19', 'keyword' => 'Hai san Be Bien Da Nang', 'from' => 83, 'to' => 90],
            ['code' => 'A20', 'keyword' => 'Hai san ngon be bien', 'from' => 90, 'to' => 96],
            ['code' => 'A21', 'keyword' => 'Hai san ngon da nang be bien', 'from' => 96, 'to' => 100],
        ]);
    }
}
