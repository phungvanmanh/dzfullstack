<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMB extends Model
{
    use HasFactory;

    protected $table = 'user_m_b_s';

    protected $fillable = [
        'user_mb',
        'is_active',
    ];
}
