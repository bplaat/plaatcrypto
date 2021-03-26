<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\CoinUser;
use App\Models\Transaction;
use App\Models\User;
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
        $transactions = $transactions->sortByDesc('created_at')
            ->paginate(config('pagination.web.limit'))->withQueryString();

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
        $coin = Coin::where('id', $fields['coin_id'])->first();
        $coinUserQuery = CoinUser::where('coin_id', $fields['coin_id'])->where('user_id', Auth::id());
        if ($coinUserQuery->count() > 0) {
            // Recalculate total coin amount
            $amount = 0;
            $transactions = Transaction::where('coin_id', $fields['coin_id'])->where('user_id', Auth::id())->get();
            foreach ($transactions as $transaction) {
                if ($transaction->type == Transaction::TYPE_BUY) {
                    $amount += $transaction->amount;
                }
                if ($transaction->type == Transaction::TYPE_SELL) {
                    $amount -= $transaction->amount;
                }
            }
            Auth::user()->coins()->updateExistingPivot($coin, [
                'amount' => $amount
            ]);
        } else {
            Auth::user()->coins()->attach($coin, [
                'amount' => $fields['amount']
            ]);
        }

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

        // Process transaction
        $coin = Coin::where('id', $fields['coin_id'])->first();

        // Recalculate total coin amount
        $amount = 0;
        $transactions = Transaction::where('coin_id', $fields['coin_id'])->where('user_id', Auth::id())->get();
        foreach ($transactions as $transaction) {
            if ($transaction->type == Transaction::TYPE_BUY) {
                $amount += $transaction->amount;
            }
            if ($transaction->type == Transaction::TYPE_SELL) {
                $amount -= $transaction->amount;
            }
        }
        Auth::user()->coins()->updateExistingPivot($coin, [
            'amount' => $amount
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
