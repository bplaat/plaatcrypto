@extends('layout')

@section('title', __('admin/coins.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.coins.index') }}">@lang('admin/coins.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/coins.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.coins.create') }}">@lang('admin/coins.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/coins.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/coins.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($coins->count() > 0)
            {{ $coins->links() }}

            <div class="columns is-multiline">
                @foreach ($coins as $coin)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('admin.coins.show', $coin) }}">{{ $coin->name }}</a>
                            </h2>

                            <p><span class="tag">{{ $coin->symbol }}</a></span></p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $coins->links() }}
        @else
            <p><i>@lang('admin/coins.index.empty')</i></p>
        @endif
    </div>
@endsection
