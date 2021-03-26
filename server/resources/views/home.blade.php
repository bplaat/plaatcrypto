@extends('layout')

@section('title', __('home.title'))

@section('content')
    <div class="content">
        @auth
            <h1 class="title">@lang('home.header_auth', ['user.firstname' => Auth::user()->firstname])</h1>
        @else
            <h1 class="title">@lang('home.header_guest', ['app.name' => config('app.name')])</h1>
        @endauth
    </div>
@endsection
