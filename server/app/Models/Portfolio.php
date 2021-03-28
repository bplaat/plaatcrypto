<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
