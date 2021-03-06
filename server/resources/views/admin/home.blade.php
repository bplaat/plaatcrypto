@extends('layout')

@section('title', __('admin/home.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/home.header')</h1>

    <div class="buttons">
        <a class="button" href="{{ route('admin.users.index') }}">@lang('admin/home.users')</a>
        <a class="button" href="{{ route('admin.coins.index') }}">@lang('admin/home.coins')</a>
        <a class="button" href="{{ route('admin.portfolios.index') }}">@lang('admin/home.portfolios')</a>
        <a class="button" href="{{ route('admin.transactions.index') }}">@lang('admin/home.transactions')</a>
    </div>
@endsection
