<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGiaRenLuyen extends Model
{
    use HasFactory;

    protected $table = 'danh_gia_ren_luyens';

    protected $fillable = [
        'ma_sinh_vien',
        'ho_va_ten',
        'ho_lot',
        'ten_sinh_vien',
        'dien_thoai',
        'dia_chi',
        'email',
        'nganh_hoc',
        'id_sinh_vien',
        'ky_hoc',
        'id_ky_hoc',
        'diem_tich_luy',
        'xep_loai',
        'diem_quy_doi',
        'id_giang_vien',
        'is_done',
        'status_student',
        'id_danh_gia'
    ];
}
