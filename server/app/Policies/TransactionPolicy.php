<?php

namespace App\Policies;

use App\Models\PortfolioUser;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TransactionPolicy
{
    use HandlesAuthorization;

    // You need to be the onwer of a transaction to view and update it
    public function view(User $user, Transaction $transaction)
    {
        $portfolioUser = PortfolioUser::where('portfolio_id', $transaction->portfolio_id)->where('user_id', $user->id);
        return $portfolioUser->count() == 1;
    }

    public function update(User $user, Transaction $transaction)
    {
        return $this->view($user, $transaction);
    }

    public function delete(User $user, Transaction $transaction)
    {
        return $this->view($user, $transaction);
    }
}
