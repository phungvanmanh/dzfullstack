<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeCuong extends Model
{
    use HasFactory;
    protected $table = 'de_cuongs';

    protected $fillable = [
        'loai_mon_hoc',
        'ten_mon_hoc',
        'ma_mon_hoc',
        'quy_tac',
        'noi_dung_sgk',
        'id_quy_tac',
        'CLO',
        'CONT',
    ];
}
