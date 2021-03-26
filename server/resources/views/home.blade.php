@extends('layout')

@section('title', __('home.title'))

@section('content')
    <div class="content">
        @auth
            <h1 class="title is-spaced">@lang('home.header_auth', ['user.firstname' => Auth::user()->firstname])</h1>

            <h2 class="subtitle is-5">@lang('home.holdings')</h1>

            @foreach (Auth::user()->coins as $coin)
                <div class="box content">
                    <h3 class="title is-5">{{ $coin->name }} ({{ $coin->symbol }})</h3>
                    <p>@lang('home.amount'): <strong>{{ $coin->pivot->amount }} {{ $coin->symbol }}</strong></h3>
                </div>
            @endforeach
        @else
            <h1 class="title is-spaced">@lang('home.header_guest', ['app.name' => config('app.name')])</h1>
        @endauth
    </div>
@endsection
