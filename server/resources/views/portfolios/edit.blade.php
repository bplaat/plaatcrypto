@extends('layout')

@section('title', __('portfolios.edit.title', ['portfolio.name' => $portfolio->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('portfolios.index') }}">@lang('portfolios.index.breadcrumb')</a></li>
            <li><a href="{{ route('portfolios.show', $portfolio) }}">{{ $portfolio->name }}</a></li>
            <li class="is-active"><a href="{{ route('portfolios.edit', $portfolio) }}">@lang('portfolios.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('portfolios.edit.header')</h1>

    <form method="POST" action="{{ route('portfolios.update', $portfolio) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('portfolios.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $portfolio->name) }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('portfolios.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
