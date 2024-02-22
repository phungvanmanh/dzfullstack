<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongKeKeyWord extends Model
{
    use HasFactory;

    protected $table = 'thong_ke_key_words';

    protected $fillable = [
        'ngay_thong_ke',
        'id_keyword',
        'so_lan_click',
        'key_word'
    ];
}
