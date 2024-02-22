<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    use HasFactory;

    protected $table = "proxies";
    protected $fillable = [
        'ip',
        'port',
        'username',
        'password',
        'status',
        'id_nguoi_dung',
        'key'
    ];
}
