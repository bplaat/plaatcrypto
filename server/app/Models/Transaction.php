<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // A transaction can be a buy or a sell transaction
    const TYPE_BUY = 0;
    const TYPE_SELL = 1;

    protected $fillable = [
        'portfolio_id',
        'name',
        'type',
        'coin_id',
        'amount',
        'price',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    // A transaction belongs to a portfolio
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    // A transaction belongs to a coin
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%');
    }
}
