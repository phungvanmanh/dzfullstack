<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binance extends Model
{
    use HasFactory;

    protected $table = "binances";
    protected $fillable = [
        'ETHUSDTFundingRate',
        'ETHUSDTFundingRateDaily',
        'ETHUSDFundingRate',
        'ETHUSDFundingRateDaily',
        'time',
    ];
}
