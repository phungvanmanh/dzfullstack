<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoTask extends Model
{
    use HasFactory;
    protected $table = 'giao_tasks';
    protected $fillable = [
        'id_giao',
        'list_nhan',
        'tieu_de',
        'thoi_gian_nhan',
        'deadline',
        'tinh_trang',
        'noi_dung'
    ];

}
