<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    use HasFactory;
    protected $table = 'cham_congs';
    protected $fillable = [
        'id_nhan_vien',
        'ghi_chu',
        'ip_cham_cong',
        'trang_thai',
        'ca',
    ];
}
