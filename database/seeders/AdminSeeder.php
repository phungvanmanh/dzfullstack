<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('nhan_viens')->delete();

        DB::table('nhan_viens')->truncate();

        DB::table('nhan_viens')->insert([
            [
                'email'                 => 'admin@master.com',
                'ho_va_ten'             => 'Admin',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0905523543',
                'facebook'              => 'https://www.facebook.com/profile.php?id=100013543428933',
                'ngay_bat_dau_lam'      => '2023-01-01',
                'id_quyen'              => '0',
                'ngay_sinh'             => '2023-01-01',
                'anh_dai_dien'          => 'https://tinyurl.com/avatar-admin',
                'is_open'               => 1,
                'ten_goi_nho'           => 'AD',
            ],

            [
                'email'                 => 'vodinhquochuy1511@gmail.com',
                'ho_va_ten'             => 'Võ Đình Quốc Huy',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0889470271',
                'facebook'              => 'https://www.facebook.com/profile.php?id=100008012501789',
                'ngay_bat_dau_lam'      => '2023-01-01',
                'id_quyen'              => '1',
                'ngay_sinh'             => '2023-01-01',
                'anh_dai_dien'          => '/assets/images/avatars/huy_anh_dai_dien.jpg',
                'is_open'               => 1,
                'ten_goi_nho'           => 'Kin',
            ],

            [
                'email'                 => 'hoangcongtruong10102001@gmail.com',
                'ho_va_ten'             => 'Hoàng Công Trường',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0917776290',
                'facebook'              => 'https://www.facebook.com/Kun101001',
                'ngay_bat_dau_lam'      => '2023-01-01',
                'id_quyen'              => '1',
                'ngay_sinh'             => '2001-10-10',
                'anh_dai_dien'          => '/assets/images/avatars/truong_anh_dai_dien.jpg',
                'is_open'               => 1,
                'ten_goi_nho'           => 'Bot',
            ],

            [
                'email'                 => 'nguyenphong080701@gmail.com',
                'ho_va_ten'             => 'Nguyễn Văn Phong',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0345884657',
                'facebook'              => 'https://www.facebook.com/nguyenphong871',
                'ngay_bat_dau_lam'      => '2023-01-01',
                'id_quyen'              => '1',
                'ngay_sinh'             => '2023-07-08',
                'anh_dai_dien'          => '/assets/images/avatars/phong_anh_dai_dien.jpg',
                'is_open'               => 1,
                'ten_goi_nho'           => 'SMG',
            ],

            [
                'email'                 => 'manhsubcheo2@gmail.com',
                'ho_va_ten'             => 'Phùng Văn Mạnh',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0369368075',
                'facebook'              => 'https://www.facebook.com/vanmanh1330112003',
                'ngay_bat_dau_lam'      => '2023-01-01',
                'id_quyen'              => '1',
                'ngay_sinh'             => '2023-07-08',
                'anh_dai_dien'          => '/assets/images/avatars/manh_anh_dai_dien.jpg',
                'is_open'               => 1,
                'ten_goi_nho'           => 'MGV',

            ],

            [
                'email'                 => 'Bonpro2701@gmail.com',
                'ho_va_ten'             => 'Phan Minh Tiến',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0905074885',
                'facebook'              => 'https://www.facebook.com/profile.php?id=100006591435524',
                'ngay_bat_dau_lam'      => '2023-01-01',
                'id_quyen'              => '1',
                'ngay_sinh'             => '2023-07-08',
                'anh_dai_dien'          => '/assets/images/avatars/tien_anh_dai_dien.jpg',
                'is_open'               => 1,
                'ten_goi_nho'           => 'MU',
            ],

            [
                'email'                 => 'thanhtruong23111999@gmail.com',
                'ho_va_ten'             => 'Lê Thanh Trường',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0376659652',
                'facebook'              => 'https://www.facebook.com/thanhtruong2311',
                'ngay_bat_dau_lam'      => '2023-01-01',
                'id_quyen'              => '1',
                'ngay_sinh'             => '1999-11-23',
                'anh_dai_dien'          => '/assets/images/avatars/mid_anh_dai_dien.jpg',
                'is_open'               => 1,
                'ten_goi_nho'           => 'MID',
            ],
            [
                'email'                 => 'duykhanhtran17062003@gmail.com',
                'ho_va_ten'             => 'Trần Nguyễn Duy Khánh',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0905081330',
                'facebook'              => 'https://www.facebook.com/profile.php?id=100042505665348',
                'ngay_bat_dau_lam'      => '2023-01-18',
                'id_quyen'              => '1',
                'ngay_sinh'             => '1999-11-23',
                'anh_dai_dien'          => '/assets/images/avatars/duy_khanh.jpg',
                'is_open'               => 1,
                'ten_goi_nho'           => 'SKY',
            ],

            [
                'email'                 => 'nguyenvuhuy2110@gmail.com',
                'ho_va_ten'             => 'Nguyễn Vũ Huy',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0394682134',
                'facebook'              => 'https://www.facebook.com/NVH.ton',
                'ngay_bat_dau_lam'      => '2023-02-18',
                'id_quyen'              => '1',
                'ngay_sinh'             => '1999-11-23',
                'anh_dai_dien'          => '/assets/images/avatars/avatar-1.png',
                'is_open'               => 1,
                'ten_goi_nho'           => 'FAT',
            ],

            [
                'email'                 => 'thachtruongcong93@gmail.com',
                'ho_va_ten'             => 'Trương Công Thạch',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0123456789',
                'facebook'              => 'https://www.facebook.com/conggthach',
                'ngay_bat_dau_lam'      => '2023-02-18',
                'id_quyen'              => '1',
                'ngay_sinh'             => '1999-11-23',
                'anh_dai_dien'          => '/assets/images/avatars/avatar-1.png',
                'is_open'               => 1,
                'ten_goi_nho'           => 'STONE',
            ],
            [
                'email'                 => 'quyen@gmail.com',
                'ho_va_ten'             => 'Quyên',
                'password'              => bcrypt(123456),
                'so_dien_thoai'         => '0123456789',
                'facebook'              => '',
                'ngay_bat_dau_lam'      => '2023-02-18',
                'id_quyen'              => '1',
                'ngay_sinh'             => '1999-11-23',
                'anh_dai_dien'          => '/assets/images/avatars/avatar-1.png',
                'is_open'               => 1,
                'ten_goi_nho'           => 'Đại tẩu',
            ],
        ]);
    }
}
