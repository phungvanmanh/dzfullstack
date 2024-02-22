<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HocVienLopHoc extends Model
{
    use HasFactory;

    protected $table = "hoc_vien_lop_hocs";

    protected $fillable = [
        'id_hoc_vien',
        'id_lop_hoc',
        'is_hoc_vien',
        'id_nhan_vien_add_facebook',
        'id_nhan_vien_add_zalo',
        'is_add_fb',
        'is_add_zalo',
    ];
}
