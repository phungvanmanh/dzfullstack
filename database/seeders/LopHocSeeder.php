<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LopHocSeeder extends Seeder
{
    public function run()
    {
        DB::table('lop_hocs')->delete();

        DB::table('lop_hocs')->truncate();

        DB::table('lop_hocs')->insert([
            [
                'id_khoa_hoc'               => 1,
                'id_nhan_vien_day'          => 1,
                'ten_lop_hoc'               => "Laravel 10",
                'ngay_bat_dau_hoc'          => "2022-12-27",
                'is_mo_dang_ky'             => 1,
                'link_driver_lop_hoc'       => null,
                'link_zalo_lop'             => "https://zalo.me/g/evebvb911",
                'link_facebook_lop'         => "https://www.facebook.com/messages/t/5499937266751150",
                'thu_trong_tuan'            => "3,5,7",
            ],
            [
                'id_khoa_hoc'               => 1,
                'id_nhan_vien_day'          => 1,
                'ten_lop_hoc'               => "Laravel 11",
                'ngay_bat_dau_hoc'          => "2023-02-06",
                'is_mo_dang_ky'             => 1,
                'link_driver_lop_hoc'       => null,
                'link_zalo_lop'             => "https://zalo.me/g/vnrmuq023",
                'link_facebook_lop'         => null,
                'thu_trong_tuan'            => "2,4,6",
            ],
            [
                'id_khoa_hoc'               => 2,
                'id_nhan_vien_day'          => 1,
                'ten_lop_hoc'               => "Androi Mobile",
                'ngay_bat_dau_hoc'          => "2023-02-06",
                'is_mo_dang_ky'             => 1,
                'link_driver_lop_hoc'       => null,
                'link_zalo_lop'             => "https://zalo.me/g/vnrmuq023",
                'link_facebook_lop'         => null,
                'thu_trong_tuan'            => "2,4,6",
            ],

        ]);
    }
}
