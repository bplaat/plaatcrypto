<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCoinsController extends Controller
{
    // Admin coins index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $coins = Coin::search($query)->get();
        } else {
            $coins = Coin::all();
        }
        $coins = $coins->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin coins index view
        return view('admin.coins.index', ['coins' => $coins]);
    }

    // Admin coins store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'symbol' => 'required|min:2|max:6|unique:coins'
        ]);

        // Create coin
        $coin = Coin::create([
            'name' => $fields['name'],
            'symbol' => strtoupper($fields['symbol'])
        ]);

        // Go to the new admin coin show page
        return redirect()->route('admin.coins.show', $coin);
    }

    // Admin coins show route
    public function show(coin $coin)
    {
        return view('admin.coins.show', [ 'coin' => $coin ]);
    }

    // Admin coins edit route
    public function edit(coin $coin)
    {
        return view('admin.coins.edit', ['coin' => $coin]);
    }

    // Admin coins update route
    public function update(Request $request, coin $coin)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'symbol' => [
                'required',
                'min:2',
                'max:6',
                Rule::unique('coins')->ignore($coin->symbol, 'symbol')
            ]
        ]);

        // Update coin
        $coin->update([
            'name' => $fields['name'],
            'symbol' => strtoupper($fields['symbol'])
        ]);

        // Go to the admin coin show page
        return redirect()->route('admin.coins.show', $coin);
    }

    // Admin coins delete route
    public function delete(coin $coin)
    {
        // Delete coin
        $coin->delete();

        // Go to the coins index page
        return redirect()->route('admin.coins.index');
    }
}
