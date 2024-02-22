<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class MailTools extends Model
{
    use HasFactory;

    protected $table = "mail_tools";
    protected $fillable = [
        'full_name',
        'email',
        'email_khoi_phuc',
        'password',
        'dob',
        'phone',
        'mailverify',
        'sex',
        'UserAgent',
        'ChanelYoutube',
        'id_nhan_vien',
        'token_phone',
        'count_farm',
        'cookies',
        'is_die',
        'is_review',
    ];
}
