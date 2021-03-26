<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // A transaction can be a buy or a sell transaction
    const TYPE_BUY = 0;
    const TYPE_SELL = 1;

    protected $fillable = [
        'name',
        'coin_id',
        'user_id',
        'type',
        'amount',
        'price',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];
}
