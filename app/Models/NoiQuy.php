<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoiQuy extends Model
{
    use HasFactory;

    protected $table = 'noi_quies';
    protected $fillable = [
        'noi_dung',
        'tinh_trang',
    ];
}
