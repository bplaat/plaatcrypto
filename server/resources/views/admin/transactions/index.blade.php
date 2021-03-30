@extends('layout')

@section('title', __('admin/transactions.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.transactions.index') }}">@lang('admin/transactions.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/transactions.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.transactions.create') }}">@lang('admin/transactions.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/transactions.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/transactions.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($transactions->count() > 0)
            {{ $transactions->links() }}

            <div class="columns is-multiline">
                @foreach ($transactions as $transaction)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('admin.transactions.show', $transaction) }}">{{ $transaction->name }}</a>
                            </h2>

                            @if ($transaction->type == App\Models\Transaction::TYPE_BUY)
                                <p>@lang('admin/transactions.index.buying', ['coin' => '<strong>' . formatNumber($transaction->amount) . ' <a href="' . route('admin.coins.show', $transaction->coin) . '">' . $transaction->coin->symbol . '</a></strong>', 'price' => '<strong>' . formatNumber($transaction->price) . ' USDT</strong>', 'time' => '<strong>' . $transaction->created_at->diffForHumans() . '</strong>'])</p>
                            @endif

                            @if ($transaction->type == App\Models\Transaction::TYPE_SELL)
                                <p>@lang('admin/transactions.index.selling', ['coin' => '<strong>' . formatNumber($transaction->amount) . ' <a href="' . route('admin.coins.show', $transaction->coin) . '">' . $transaction->coin->symbol . '</a></strong>', 'price' => '<strong>' . formatNumber($transaction->price) . ' USDT</strong>', 'time' => '<strong>' . $transaction->created_at->diffForHumans() . '</strong>'])</p>
                            @endif

                            <p>@lang('admin/transactions.index.from_portfolio', ['portfolio.name' => '<a href="' . route('admin.portfolios.show', $transaction->portfolio) . '">' . $transaction->portfolio->name . '</a>' ])</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $transactions->links() }}
        @else
            <p><i>@lang('admin/transactions.index.empty')</i></p>
        @endif
    </div>
@endsection
