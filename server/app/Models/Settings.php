<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_coin_id',
        'default_commission_percent',
        'default_commission_coin_id'
    ];

    // A setting belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
