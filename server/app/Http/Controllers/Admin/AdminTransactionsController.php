<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTransactionsController extends Controller
{
    // Admin transactions index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $transactions = Transaction::search($query)->get();
        } else {
            $transactions = Transaction::all();
        }
        $transactions = $transactions->sortByDesc('created_at')
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return the admin transactions index view
        return view('admin.transactions.index', ['transactions' => $transactions]);
    }

    // Admin transactions create route
    public function create()
    {
        // Get all the data
        $portfolios = Portfolio::all();
        $coins = Coin::all();

        // Return the admin transactions create view
        return view('admin.transactions.create', ['portfolios' => $portfolios, 'coins' => $coins]);
    }

    // Admin transactions store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'portfolio_id' => 'required|integer|exists:portfolios,id',
            'name' => 'required|min:2|max:48',
            'coin_id' => 'required|integer|exists:coins,id',
            'type' => 'required|integer|digits_between:' . Transaction::TYPE_BUY . ',' . Transaction::TYPE_SELL,
            'amount' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i:s'
        ]);

        // Create transaction
        $transaction = Transaction::create([
            'portfolio_id' => $fields['portfolio_id'],
            'name' => $fields['name'],
            'coin_id' => $fields['coin_id'],
            'type' => $fields['type'],
            'amount' => $fields['amount'],
            'price' => $fields['price'],
            'date' => $fields['date'] . ' ' . $fields['time']
        ]);

        // Go to the new admin transaction show page
        return redirect()->route('admin.transactions.show', $transaction);
    }

    // Admin transactions show route
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', ['transaction' => $transaction]);
    }

    // Admin transactions edit route
    public function edit(Transaction $transaction)
    {
        // Get all the coins
        $coins = Coin::all();

        // Return the transactions edit view
        return view('admin.transactions.edit', ['transaction' => $transaction, 'coins' => $coins]);
    }

    // Admin transactions update route
    public function update(Request $request, Transaction $transaction)
    {
        // Validate input
        $fields = $request->validate([
            'portfolio_id' => 'required|integer|exists:portfolios,id',
            'name' => 'required|min:2|max:48',
            'coin_id' => 'required|integer|exists:coins,id',
            'type' => 'required|integer|digits_between:' . Transaction::TYPE_BUY . ',' . Transaction::TYPE_SELL,
            'amount' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i:s'
        ]);

        // Update transaction
        $transaction->update([
            'portfolio_id' => $fields['portfolio_id'],
            'name' => $fields['name'],
            'coin_id' => $fields['coin_id'],
            'type' => $fields['type'],
            'amount' => $fields['amount'],
            'price' => $fields['price'],
            'date' => $fields['date'] . ' ' . $fields['time']
        ]);

        // Go to the admin transaction show page
        return redirect()->route('admin.transactions.show', $transaction);
    }

    // Admin transactions delete route
    public function delete(Transaction $transaction)
    {
        // Delete transaction
        $transaction->delete();

        // Go to the admin transactions index page
        return redirect()->route('admin.transactions.index');
    }
}
