@extends('layout')

@section('title', __('transactions.show.title', ['transaction.name' => $transaction->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('transactions.index') }}">@lang('transactions.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('transactions.show', $transaction) }}">{{ $transaction->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $transaction->name }}</h1>
        <p><span class="tag">{{ $transaction->date }}</a></span></p>

        <div class="buttons">
            <a class="button is-link" href="{{ route('transactions.edit', $transaction) }}">@lang('transactions.show.edit')</a>
            <a class="button is-danger" href="{{ route('transactions.delete', $transaction) }}">@lang('transactions.show.delete')</a>
        </div>
    </div>
@endsection
