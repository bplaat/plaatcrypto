@extends('layout')

@section('title', __('transactions.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('transactions.index') }}">@lang('transactions.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('transactions.create') }}">@lang('transactions.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('transactions.create.header')</h1>

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('transactions.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', 'Normal transaction at ' . date('Y-m-d H:i:s')) }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="coin_id">@lang('transactions.create.coin')</label>

            <div class="control">
                <div class="select is-fullwidth @error('coin_id') is-danger @enderror">
                    <select id="coin_id" name="coin_id" required>
                        @foreach ($coins as $coin)
                            <option value="{{ $coin->id }}" @if ($coin->id == old('coin_id')) selected @endif>
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
            <label class="label" for="type">@lang('transactions.create.type')</label>

            <div class="control">
                <div class="select is-fullwidth @error('type') is-danger @enderror">
                    <select id="type" name="type" required>
                        <option value="{{ App\Models\Transaction::TYPE_BUY }}" @if (App\Models\Transaction::TYPE_BUY == old('type', App\Models\Transaction::TYPE_BUY)) selected @endif>
                            @lang('transactions.create.type_buy')
                        </option>

                        <option value="{{ App\Models\Transaction::TYPE_SELL }}" @if (App\Models\Transaction::TYPE_SELL == old('type', App\Models\Transaction::TYPE_BUY)) selected @endif>
                            @lang('transactions.create.type_sell')
                        </option>
                    </select>
                </div>
            </div>

            @error('type')
                <p class="help is-danger">{{ $errors->first('type') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="amount">@lang('transactions.create.amount')</label>

            <div class="control">
                <input class="input @error('amount') is-danger @enderror" type="number" min="0" step="0.000001" id="amount" name="amount" value="{{ old('amount') }}" required>
            </div>

            @error('amount')
                <p class="help is-danger">{{ $errors->first('amount') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="price">@lang('transactions.create.price')</label>

            <div class="control">
                <input class="input @error('price') is-danger @enderror" type="number" min="0" step="0.000001" id="price" name="price" value="{{ old('price') }}" required>
            </div>

            @error('price')
                <p class="help is-danger">{{ $errors->first('price') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="date">@lang('transactions.create.date')</label>

                    <div class="control">
                        <input class="input @error('date') is-danger @enderror" type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                    </div>

                    @error('date')
                        <p class="help is-danger">{{ $errors->first('date') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="time">@lang('transactions.create.time')</label>

                    <div class="control">
                        <input class="input @error('time') is-danger @enderror" type="time" id="time" name="time" value="{{ old('time', date('H:i:s')) }}" required>
                    </div>

                    @error('time')
                        <p class="help is-danger">{{ $errors->first('time') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('transactions.create.button')</button>
            </div>
        </div>
    </form>
@endsection
