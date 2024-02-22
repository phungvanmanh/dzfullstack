<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichHoc extends Model
{
    use HasFactory;

    protected $table = 'lich_hocs';

    protected $fillable = [
        'id_buoi_hoc',
        'id_hoc_vien',
        'tinh_trang',
        'ly_do_vang',
        'danh_gia_bai_tap',
        'id_nhan_vien_danh_gia',
        'hoc_vien_danh_gia_buoi_hoc',
        'noi_dung_danh_gia',
        'anh_minh_chung',
        'is_share'
    ];
}
