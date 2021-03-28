<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    protected $fillable = [
        'name'
    ];

    // A portfolio belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    // A protfolio has many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%');
    }

    // Search collection by a query
    public static function searchCollection($collection, $query)
    {
        return $collection->filter(function ($portfolio) use ($query) {
            return Str::contains(strtolower($portfolio->name), strtolower($query));
        });
    }
}
