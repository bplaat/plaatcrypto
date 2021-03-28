<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioUser extends Model
{
    protected $table = 'portfolio_user';

    // A user can be a viewer or an onwer of a portfolio
    const ROLE_VIEWER = 0;
    const ROLE_ONWER = 1;

    protected $fillable = [
        'portfolio_id',
        'user_id',
        'role'
    ];
}
