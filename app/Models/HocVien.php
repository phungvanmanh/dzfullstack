<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class HocVien extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $table ="hoc_viens";
    protected $fillable =
    [
        'ho_va_ten',
        'ho_lot',
        'ten',
        'email',
        'so_dien_thoai',
        'sologan',
        'youtube',
        'facebook',
        'anh_dai_dien',
        'mo_ta_trinh_do',
        'nguoi_gioi_thieu',
        'id_nhan_vien_ref',
        'id_nhan_vien_support',
        'danh_sach_teamview',
        'tai_khoan_git',
        'id_lop_dang_ky',
        'password',
        'uuid',
        'is_hoc_vien',
        'skill_level',
        'name_zalo',
        'is_cho_lop',
        'ip_dang_ki'
    ];
}
