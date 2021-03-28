@extends('layout')

@section('title', __('portfolios.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('portfolios.index') }}">@lang('portfolios.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('portfolios.create') }}">@lang('portfolios.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('portfolios.create.header')</h1>

    <form method="POST" action="{{ route('portfolios.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('portfolios.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('portfolios.create.button')</button>
            </div>
        </div>
    </form>
@endsection
