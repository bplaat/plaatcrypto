<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = [
        'name',
        'symbol'
    ];

    // A coin has many positions
    public function positions()
    {
        return $this->hasMany(CoinPosition::class);
    }

    // A coin has many from transactions
    public function fromTransactions()
    {
        return $this->hasMany(Transaction::class, 'from_coin_id');
    }

    // A coin has many to transactions
    public function toTransactions()
    {
        return $this->hasMany(Transaction::class, 'to_coin_id');
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('symbol', 'LIKE', '%' . $query . '%');
    }
}
