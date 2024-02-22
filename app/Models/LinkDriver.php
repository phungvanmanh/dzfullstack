<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkDriver extends Model
{
    use HasFactory;

    protected $table = 'link_drivers';
    protected $fillable = [
        'ten_link',
        'link',
        'tinh_trang',
    ];
}
