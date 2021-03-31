<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PortfoliosController extends Controller
{
    // Portfolios index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $portfolios = Portfolio::searchCollection(Auth::user()->portfolios, $query);
        } else {
            $portfolios = Auth::user()->portfolios;
        }
        $portfolios = $portfolios->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return portfolios index view
        return view('portfolios.index', ['portfolios' => $portfolios]);
    }

    // Pportfolios create route
    public function create()
    {
        // Get all users
        $users = User::all();

        // Return portfolios create view
        return view('portfolios.create', ['users' => $users]);
    }

    // Portfolios store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48'
        ]);

        // Create portfolio
        $portfolio = Portfolio::create([
            'name' => $fields['name']
        ]);

        // Add user to portfolio as an onwer
        $portfolio->users()->attach(Auth::id(), [
            'role' => PortfolioUser::ROLE_ONWER
        ]);

        // Go to the new portfolio show page
        return redirect()->route('portfolios.show', $portfolio);
    }

    // Portfolios show route
    public function show(Portfolio $portfolio)
    {
        // Select profile information
        $portfolioUsers = $portfolio->users->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit'))->withQueryString();
        $portfolioOnwers = $portfolioUsers->filter(function ($user) {
            return $user->pivot->role == PortfolioUser::ROLE_ONWER;
        });
        $users = User::all()->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE);

        // Return portfolio show view
        return view('portfolios.show', [
            'portfolio' => $portfolio,

            'portfolioUsers' => $portfolioUsers,
            'portfolioOnwers' => $portfolioOnwers,
            'users' => $users
        ]);
    }

    // Portfolios edit route
    public function edit(Portfolio $portfolio)
    {
        return view('portfolios.edit', ['portfolio' => $portfolio]);
    }

    // Portfolios update route
    public function update(Request $request, portfolio $portfolio)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48'
        ]);

        // Update portfolio
        $portfolio->update([
            'name' => $fields['name']
        ]);

        // Go to the portfolio show page
        return redirect()->route('portfolios.show', $portfolio);
    }

    // Portfolios delete route
    public function delete(Portfolio $portfolio)
    {
        // Delete portfolio
        $portfolio->delete();

        // Go to the portfolios index page
        return redirect()->route('portfolios.index');
    }
}
