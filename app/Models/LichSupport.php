<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSupport extends Model
{
    use HasFactory;

    protected $table = 'lich_supports';

    protected $fillable = [
        'id_nhan_vien',
        'ngay_lam_viec',
        'buoi_lam_viec',
    ];
}
