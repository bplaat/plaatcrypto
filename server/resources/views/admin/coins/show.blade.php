@extends('layout')

@section('title', __('admin/coins.show.title', ['coin.name' => $coin->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.coins.index') }}">@lang('admin/coins.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.coins.show', $coin) }}">{{ $coin->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $coin->name }}</h1>
        <p><span class="tag">{{ $coin->symbol }}</a></span></p>

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.coins.edit', $coin) }}">@lang('admin/coins.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.coins.delete', $coin) }}">@lang('admin/coins.show.delete')</a>
        </div>
    </div>
@endsection
