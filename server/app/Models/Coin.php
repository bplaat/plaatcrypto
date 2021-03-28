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

    // A coin has many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('symbol', 'LIKE', '%' . $query . '%');
    }
}
