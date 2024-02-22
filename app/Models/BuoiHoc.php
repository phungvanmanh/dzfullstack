<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuoiHoc extends Model
{
    use HasFactory;
    protected $table = 'buoi_hocs';
    protected $fillable = [
        'id_lop_hoc',
        'thu_tu_buoi_khoa_hoc',
        'link_video',
        'link_notepad',
        'gio_bat_dau',
        'gio_ket_thuc',
        'id_nhan_vien_day',
        'is_bai_tap',
    ];
}
