<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    // Transactions index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $transactions = Transaction::search($query)->get();
        } else {
            $transactions = Transaction::all();
        }
        $transactions = $transactions->paginate(config('pagination.web.limit'))->withQueryString();

        // Return the transactions index view
        return view('transactions.index', ['transactions' => $transactions]);
    }

    // Transactions create route
    public function create()
    {
        // Get all the coins
        $coins = Coin::all();

        // Return the transactions create view
        return view('transactions.create', [ 'coins' => $coins ]);
    }

    // Transactions store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'coin_id' => 'required|integer|exists:coins,id',
            'type' => 'required|integer|digits_between:' . Transaction::TYPE_BUY . ',' . Transaction::TYPE_SELL,
            'amount' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i:s'
        ]);

        // Create transaction
        $transaction = Auth::user()->transactions()->create([
            'name' => $fields['name'],
            'coin_id' => $fields['coin_id'],
            'type' => $fields['type'],
            'amount' => $fields['amount'],
            'price' => $fields['price'],
            'date' => $fields['date'] . ' ' . $fields['time']
        ]);

        // Process transaction
        // $coin = Coin::first('id', $fields['coin_id']);

        // Auth::user()->coins()->attach($coin, [
        //     'amount' => $fields['amount']
        // ]);

        // Go to the new transaction show page
        return redirect()->route('transactions.show', $transaction);
    }

    // Transactions show route
    public function show(Transaction $transaction)
    {
        return view('transactions.show', [ 'transaction' => $transaction ]);
    }

    // Transactions edit route
    public function edit(Transaction $transaction)
    {
        // Get all the coins
        $coins = Coin::all();

        // Return the transactions edit view
        return view('transactions.edit', ['transaction' => $transaction, 'coins' => $coins]);
    }

    // Transactions update route
    public function update(Request $request, Transaction $transaction)
    {
        // Validate input
        $fields = $request->validate([
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
            'name' => $fields['name'],
            'coin_id' => $fields['coin_id'],
            'type' => $fields['type'],
            'amount' => $fields['amount'],
            'price' => $fields['price'],
            'date' => $fields['date'] . ' ' . $fields['time']
        ]);

        // Go to the transaction show page
        return redirect()->route('transactions.show', $transaction);
    }

    // Transactions delete route
    public function delete(Transaction $transaction)
    {
        // Delete transaction
        $transaction->delete();

        // Go to the transactions index page
        return redirect()->route('transactions.index');
    }
}
