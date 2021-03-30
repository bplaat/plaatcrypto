@extends('layout')

@section('title', __('admin/transactions.show.title', ['transaction.name' => $transaction->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.transactions.index') }}">@lang('admin/transactions.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.transactions.show', $transaction) }}">{{ $transaction->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $transaction->name }}</h1>

        @if ($transaction->type == App\Models\Transaction::TYPE_BUY)
            <p>@lang('admin/transactions.show.buying', ['coin' => '<strong>' . formatNumber($transaction->amount) . ' <a href="' . route('admin.coins.show', $transaction->coin) . '">' . $transaction->coin->symbol . '</a></strong>', 'price' => '<strong>' . formatNumber($transaction->price) . ' USDT</strong>', 'time' => '<strong>' . $transaction->created_at->diffForHumans() . '</strong>'])</p>
        @endif

        @if ($transaction->type == App\Models\Transaction::TYPE_SELL)
            <p>@lang('admin/transactions.show.selling', ['coin' => '<strong>' . formatNumber($transaction->amount) . ' <a href="' . route('admin.coins.show', $transaction->coin) . '">' . $transaction->coin->symbol . '</a></strong>', 'price' => '<strong>' . formatNumber($transaction->price) . ' USDT</strong>', 'time' => '<strong>' . $transaction->created_at->diffForHumans() . '</strong>'])</p>
        @endif

        <p>@lang('admin/transactions.show.from_portfolio', ['portfolio.name' => '<a href="' . route('admin.portfolios.show', $transaction->portfolio) . '">' . $transaction->portfolio->name . '</a>' ])</p>

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.transactions.edit', $transaction) }}">@lang('admin/transactions.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.transactions.delete', $transaction) }}">@lang('admin/transactions.show.delete')</a>
        </div>
    </div>
@endsection
