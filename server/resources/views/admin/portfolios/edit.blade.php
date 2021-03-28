@extends('layout')

@section('title', __('admin/portfolios.edit.title', ['portfolio.name' => $portfolio->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.portfolios.index') }}">@lang('admin/portfolios.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.portfolios.show', $portfolio) }}">{{ $portfolio->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.portfolios.edit', $portfolio) }}">@lang('admin/portfolios.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/portfolios.edit.header')</h1>

    <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/portfolios.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $portfolio->name) }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/portfolios.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
