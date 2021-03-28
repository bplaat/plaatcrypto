@extends('layout')

@section('title', __('admin/portfolios.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.portfolios.index') }}">@lang('admin/portfolios.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.portfolios.create') }}">@lang('admin/portfolios.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/portfolios.create.header')</h1>

    <form method="POST" action="{{ route('admin.portfolios.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="user_id">@lang('admin/portfolios.create.user')</label>

            <div class="control">
                <div class="select is-fullwidth @error('user_id') is-danger @enderror">
                    <select id="user_id" name="user_id" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if ($user->id == old('user_id', Auth::id())) selected @endif>
                                {{ $user->name() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @error('user_id')
                <p class="help is-danger">{{ $errors->first('user_id') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="name">@lang('admin/portfolios.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/portfolios.create.button')</button>
            </div>
        </div>
    </form>
@endsection
