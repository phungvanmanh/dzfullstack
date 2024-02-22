<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    use HasFactory;

    protected $table = "lop_hocs";

    protected $fillable = [
        'id_khoa_hoc',
        'id_nhan_vien_day',
        'ten_lop_hoc',
        'ngay_bat_dau_hoc',
        'is_mo_dang_ky',
        'link_driver_lop_hoc',
        'link_zalo_lop',
        'link_facebook_lop',
        'mo_ta_khoa',
        'thu_trong_tuan',
        'so_thang_hoc',
        'hoc_phi_theo_thang',
        'so_buoi_trong_thang',
        'is_done',
    ];

    CONST MO_DANG_KY = 1;
    CONST DONG_DANG_KY = 0;
}
