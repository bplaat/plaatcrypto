@extends('layout')

@section('title', __('admin/transactions.edit.title', ['transaction.name' => $transaction->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.transactions.index') }}">@lang('admin/transactions.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.transactions.show', $transaction) }}">{{ $transaction->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.transactions.edit', $transaction) }}">@lang('admin/transactions.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/transactions.edit.header')</h1>

    <form method="POST" action="{{ route('admin.transactions.update', $transaction) }}">
        @csrf

        <div class="field">
            <label class="label" for="portfolio_id">@lang('admin/transactions.edit.portfolio')</label>

            <div class="control">
                <div class="select is-fullwidth @error('portfolio_id') is-danger @enderror">
                    <select id="portfolio_id" name="portfolio_id" required>
                        @foreach ($portfolios as $portfolio)
                            <option value="{{ $portfolio->id }}" @if ($portfolio->id == old('portfolio_id', $transaction->portfolio_id)) selected @endif>
                                {{ $portfolio->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @error('portfolio_id')
                <p class="help is-danger">{{ $errors->first('portfolio_id') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="name">@lang('admin/transactions.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $transaction->name) }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="coin_id">@lang('admin/transactions.edit.coin')</label>

            <div class="control">
                <div class="select is-fullwidth @error('coin_id') is-danger @enderror">
                    <select id="coin_id" name="coin_id" required>
                        @foreach ($coins as $coin)
                            <option value="{{ $coin->id }}" @if ($coin->id == old('coin_id', $transaction->coin_id)) selected @endif>
                                {{ $coin->name }} ({{ $coin->symbol }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @error('coin_id')
                <p class="help is-danger">{{ $errors->first('coin_id') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="type">@lang('admin/transactions.edit.type')</label>

            <div class="control">
                <div class="select is-fullwidth @error('type') is-danger @enderror">
                    <select id="type" name="type" required>
                        <option value="{{ App\Models\Transaction::TYPE_BUY }}" @if (App\Models\Transaction::TYPE_BUY == old('type', $transaction->type)) selected @endif>
                            @lang('transactions.edit.type_buy')
                        </option>

                        <option value="{{ App\Models\Transaction::TYPE_SELL }}" @if (App\Models\Transaction::TYPE_SELL == old('type', $transaction->type)) selected @endif>
                            @lang('transactions.edit.type_sell')
                        </option>
                    </select>
                </div>
            </div>

            @error('type')
                <p class="help is-danger">{{ $errors->first('type') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="amount">@lang('admin/transactions.edit.amount')</label>

            <div class="control">
                <input class="input @error('amount') is-danger @enderror" type="number" min="0" step="0.000001" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" required>
            </div>

            @error('amount')
                <p class="help is-danger">{{ $errors->first('amount') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="price">@lang('admin/transactions.edit.price')</label>

            <div class="control">
                <input class="input @error('price') is-danger @enderror" type="number" min="0" step="0.000001" id="price" name="price" value="{{ old('price', $transaction->price) }}" required>
            </div>

            @error('price')
                <p class="help is-danger">{{ $errors->first('price') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="date">@lang('admin/transactions.edit.date')</label>

                    <div class="control">
                        <input class="input @error('date') is-danger @enderror" type="date" id="date" name="date" value="{{ old('date', date('Y-m-d', strtotime($transaction->date))) }}" required>
                    </div>

                    @error('date')
                        <p class="help is-danger">{{ $errors->first('date') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="time">@lang('admin/transactions.edit.time')</label>

                    <div class="control">
                        <input class="input @error('time') is-danger @enderror" type="time" id="time" name="time" value="{{ old('time', date('H:i:s', strtotime($transaction->date))) }}" required>
                    </div>

                    @error('time')
                        <p class="help is-danger">{{ $errors->first('time') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/transactions.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
