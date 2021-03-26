@extends('layout')

@section('title', __('admin/coins.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.coins.index') }}">@lang('admin/coins.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.coins.create') }}">@lang('admin/coins.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/coins.create.header')</h1>

    <form method="POST" action="{{ route('admin.coins.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/coins.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="symbol">@lang('admin/coins.create.symbol')</label>

            <div class="control">
                <input class="input @error('symbol') is-danger @enderror" type="text" id="symbol" name="symbol" value="{{ old('symbol') }}" required>
            </div>

            @error('symbol')
                <p class="help is-danger">{{ $errors->first('symbol') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/coins.create.button')</button>
            </div>
        </div>
    </form>
@endsection
