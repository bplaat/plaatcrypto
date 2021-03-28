<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPortfoliosController extends Controller
{
    // Admin portfolios index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $portfolios = Portfolio::search($query)->get();
        } else {
            $portfolios = Portfolio::all();
        }
        $portfolios = $portfolios->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin portfolios index view
        return view('admin.portfolios.index', ['portfolios' => $portfolios]);
    }

    // Admin portfolios create route
    public function create()
    {
        // Get all users
        $users = User::all();

        // Return admin portfolios create view
        return view('admin.portfolios.create', ['users' => $users]);
    }

    // Admin portfolios store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|min:2|max:48'
        ]);

        // Create portfolio
        $portfolio = Portfolio::create([
            'name' => $fields['name']
        ]);

        // Add user to portfolio as an onwer
        $portfolio->users()->attach($fields['user_id'], [
            'role' => PortfolioUser::ROLE_ONWER
        ]);

        // Go to the new admin portfolio show page
        return redirect()->route('admin.portfolios.show', $portfolio);
    }

    // Admin portfolios show route
    public function show(Portfolio $portfolio)
    {
        // Select profile information
        $portfolioUsers = $portfolio->users->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit'))->withQueryString();
        $portfolioOnwers = $portfolioUsers->filter(function ($user) {
            return $user->pivot->role == PortfolioUser::ROLE_ONWER;
        });
        $users = User::all()->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE);

        // Return admin portfolio show view
        return view('admin.portfolios.show', [
            'portfolio' => $portfolio,

            'portfolioUsers' => $portfolioUsers,
            'portfolioOnwers' => $portfolioOnwers,
            'users' => $users
        ]);
    }

    // Admin portfolios edit route
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', ['portfolio' => $portfolio]);
    }

    // Admin portfolios update route
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

        // Go to the admin portfolio show page
        return redirect()->route('admin.portfolios.show', $portfolio);
    }

    // Admin portfolios delete route
    public function delete(Portfolio $portfolio)
    {
        // Delete portfolio
        $portfolio->delete();

        // Go to the portfolios index page
        return redirect()->route('admin.portfolios.index');
    }
}
