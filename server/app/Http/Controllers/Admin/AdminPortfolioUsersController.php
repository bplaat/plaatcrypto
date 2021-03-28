<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioUser;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPortfolioUsersController extends Controller
{
    // Admin portfolio users store route
    public function store(Request $request, Portfolio $portfolio)
    {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|integer|digits_between:' . PortfolioUser::ROLE_VIEWER . ',' . PortfolioUser::ROLE_ONWER
        ]);

        // Create portfolio user connection
        $portfolio->users()->attach($fields['user_id'], [
            'role' => $fields['role']
        ]);

        // Go back to the portfolio page
        return redirect()->route('admin.portfolios.show', $portfolio);
    }

    // Admin portfolio users update route
    public function update(Request $request, Portfolio $portfolio, User $user)
    {
        // Validate input
        $fields = $request->validate([
            'role' => 'required|integer|digits_between:' . PortfolioUser::ROLE_VIEWER . ',' . PortfolioUser::ROLE_ONWER
        ]);

        // Check if user is not the last capatain
        if ($fields['role'] == PortfolioUser::ROLE_VIEWER) {
            $portfolioUser = $portfolio->users->firstWhere('id', $user->id);
            $portfolioOnwers = $portfolio->users->filter(function ($user) {
                return $user->pivot->role == PortfolioUser::ROLE_ONWER;
            });
            if ($portfolioUser->pivot->role == PortfolioUser::ROLE_ONWER && $portfolioOnwers->count() <= 1) {
                return redirect()->route('admin.portfolios.show', $portfolio);
            }
        }

        // Update portfolio user connection
        $portfolio->users()->updateExistingPivot($user, [
            'role' => $fields['role']
        ]);

        // Go back to the portfolio page
        return redirect()->route('admin.portfolios.show', $portfolio);
    }

    // Admin portfolio users delete route
    public function delete(Request $request, Portfolio $portfolio, User $user)
    {
        // Check if user is not the last capatain
        $portfolioUser = $portfolio->users->firstWhere('id', $user->id);
        $portfolioOnwers = $portfolio->users->filter(function ($user) {
            return $user->pivot->role == PortfolioUser::ROLE_ONWER;
        });
        if ($portfolioUser->pivot->role == PortfolioUser::ROLE_ONWER && $portfolioOnwers->count() <= 1) {
            return redirect()->route('admin.portfolios.show', $portfolio);
        }

        // Delete portfolio user connection
        $portfolio->users()->detach($user);

        // Go back to the portfolio page
        return redirect()->route('admin.portfolios.show', $portfolio);
    }
}
