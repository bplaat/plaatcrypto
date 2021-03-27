<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPosition extends Model
{
    protected $fillable = [
        'coin_id',
        'prices'
    ];
}
