<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class NhanVien extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'nhan_viens';

    protected $fillable = [
        'email',
        'ho_va_ten',
        'password',
        'so_dien_thoai',
        'facebook',
        'ngay_bat_dau_lam',
        'id_quyen',
        'ngay_sinh',
        'is_open',
        'ten_goi_nho',
        'anh_dai_dien',
        'git_account',
    ];

    public function ConnectQuyen()
    {
        return $this->belongsTo('\App\Models\PhanQuyen', 'id_quyen', 'id');
    }
}
