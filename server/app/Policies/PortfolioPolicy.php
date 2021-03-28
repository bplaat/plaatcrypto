<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\PortfolioUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    // You need to be a viewer member to view the portfolio
    public function view(User $user, Portfolio $portfolio)
    {
        $portfolioUser = PortfolioUser::where('portfolio_id', $portfolio->id)->where('user_id', $user->id);
        return $portfolioUser->count() == 1;
    }

    // You need to be an onwer update the portfolio
    public function update(User $user, Portfolio $portfolio)
    {
        $portfolioUser = PortfolioUser::where('portfolio_id', $portfolio->id)->where('user_id', $user->id);
        return $portfolioUser->count() == 1 && $portfolioUser->first()->role == PortfolioUser::ROLE_ONWER;
    }

    public function delete(User $user, Portfolio $portfolio)
    {
        return $this->update($user, $portfolio);
    }

    // Portfolio User connection
    public function create_portfolio_user(User $user, Portfolio $portfolio)
    {
        return $this->update($user, $portfolio);
    }

    public function update_portfolio_user(User $user, Portfolio $portfolio)
    {
        return $this->update($user, $portfolio);
    }

    public function delete_portfolio_user(User $user, Portfolio $portfolio)
    {
        return $this->update($user, $portfolio);
    }
}
