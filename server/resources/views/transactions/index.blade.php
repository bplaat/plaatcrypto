@extends('layout')

@section('title', __('transactions.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('transactions.index') }}">@lang('transactions.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('transactions.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('transactions.create') }}">@lang('transactions.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('transactions.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('transactions.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($transactions->count() > 0)
            {{ $transactions->links() }}

            @foreach ($transactions as $transaction)
                <div class="box content" style="height: 100%">
                    <h2 class="title is-4">
                        <a href="{{ route('transactions.show', $transaction) }}">{{ $transaction->name }}</a>
                    </h2>

                    @if ($transaction->type == App\Models\Transaction::TYPE_BUY)
                        <p>@lang('transactions.index.buying', ['coin' => '<strong>' . formatNumber($transaction->amount) . ' ' . $transaction->coin->symbol . '</strong>', 'price' => '<strong>' . formatNumber($transaction->price) . ' USDT</strong>', 'time' => '<strong>' . $transaction->created_at->diffForHumans() . '</strong>'])</p>
                    @endif

                    @if ($transaction->type == App\Models\Transaction::TYPE_SELL)
                        <p>@lang('transactions.index.selling', ['coin' => '<strong>' . formatNumber($transaction->amount) . ' ' . $transaction->coin->symbol . '</strong>', 'price' => '<strong>' . formatNumber($transaction->price) . ' USDT</strong>', 'time' => '<strong>' . $transaction->created_at->diffForHumans() . '</strong>'])</p>
                    @endif

                    <p>@lang('transactions.index.from_portfolio', ['portfolio.name' => '<a href="' . route('portfolios.show', $transaction->portfolio) . '">' . $transaction->portfolio->name . '</a>' ])</p>
                </div>
            @endforeach

            {{ $transactions->links() }}
        @else
            <p><i>@lang('transactions.index.empty')</i></p>
        @endif
    </div>
@endsection
