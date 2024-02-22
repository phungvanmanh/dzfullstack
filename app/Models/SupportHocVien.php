<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportHocVien extends Model
{
    use HasFactory;

    protected $table = 'support_hoc_viens';

    protected $fillable = [
        'id_hoc_vien',
        'id_lop_hoc',
        'id_nhan_vien',
        'noi_nhan_support',
        'noi_dung_support',
        'is_dung_teamview',
    ];
}
