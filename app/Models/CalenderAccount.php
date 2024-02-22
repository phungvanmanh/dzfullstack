<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalenderAccount extends Model
{
    use HasFactory;

    protected $table = 'calender_accounts';

    protected $fillable = [
        'id_account',
        'id_info',
        'ma_mon_hoc',
        'ten_mon_hoc',
        'ma_lop_hoc',
        'co_so',
        'phong',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
    ];
}
