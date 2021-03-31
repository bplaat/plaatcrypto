<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // A transaction can be different things
    const TYPE_TRADE = 0;
    const TYPE_COMMISSION = 1;
    const TYPE_DEPOSIT = 2;
    const TYPE_WITHDRAW = 3;
    const TYPE_STACKING = 4;

    protected $fillable = [
        'portfolio_id',
        'type',
        'from_coin_id',
        'from_amount',
        'to_coin_id',
        'to_amount',
        'date',
        'notes'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    // A transaction belongs to a portfolio
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    // A transaction belongs to a from coin
    public function fromCoin()
    {
        return $this->belongsTo(Coin::class, 'from_coin_id');
    }

    // A transaction belongs to a to coin
    public function toCoin()
    {
        return $this->belongsTo(Coin::class, 'to_coin_id');
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%');
    }

    // Search collection by a query
    public static function searchCollection($collection, $query)
    {
        return $collection->filter(function ($transaction) use ($query) {
            return Str::contains(strtolower($transaction->name), strtolower($query));
        });
    }
}
