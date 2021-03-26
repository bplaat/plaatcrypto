<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinUser extends Model
{
    protected $table = 'coin_user';

    protected $fillable = [
        'coin_id',
        'user_id',
        'amount'
    ];
}
