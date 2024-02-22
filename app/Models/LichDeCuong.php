<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichDeCuong extends Model
{
    use HasFactory;

    protected $table = 'lich_de_cuongs';

    protected $fillable = [
        'ma_mon_hoc',
        'loai_mon',
        'buoi_thu',
        'so_buoi_de_cuong',
        'tieu_de',
        'noi_dung',
    ];
}
