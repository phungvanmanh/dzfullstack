<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichLamViec extends Model
{
    use HasFactory;

    protected $table = 'lich_lam_viecs';

    protected $fillable = [
        'id_nhan_vien',
        'ngay_lam_viec',
        'buoi_lam_viec',
        'noi_dung_buoi',
        'danh_gia',
        'id_nguoi_danh_gia',
        'noi_dung_buoi_danh_gia',
        'is_trang_thai',
    ];
}
