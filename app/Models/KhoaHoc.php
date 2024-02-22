<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhoaHoc extends Model
{
    use HasFactory;

    protected $table = 'khoa_hocs';

    protected $fillable = [
        'ten_khoa_hoc',
        'mo_ta_khoa',
        'is_open',
        'so_buoi_trong_thang',
        'hoc_phi_theo_thang',
        'so_thang_hoc',
    ];
}
