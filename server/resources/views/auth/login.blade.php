@extends('layout')

@section('title', __('auth.login.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('auth.login') }}">@lang('auth.login.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('auth.login.header')</h1>

    @if (session('error'))
        <div class="notification is-danger">
            <button class="delete"></button>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <form method="POST">
        @csrf

        <div class="field">
            <label class="label" for="email">@lang('auth.login.email')</label>

            <div class="control">
                <input class="input" type="email" id="email" name="email" value="{{ old('email') }}" autofocus required>
            </div>
        </div>

        <div class="field">
            <label class="label" for="password">@lang('auth.login.password')</label>

            <div class="control">
                <input class="input" type="password" id="password" name="password" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('auth.login.button')</button>
            </div>
        </div>
    </form>
@endsection
