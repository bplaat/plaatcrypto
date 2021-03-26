<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = [
        'name',
        'symbol'
    ];

    // A coin belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('amount');
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
