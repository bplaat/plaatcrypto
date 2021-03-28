@extends('layout')

@section('title', __('portfolios.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('portfolios.index') }}">@lang('portfolios.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('portfolios.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('portfolios.create') }}">@lang('portfolios.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('portfolios.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('portfolios.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($portfolios->count() > 0)
            {{ $portfolios->links() }}

            <div class="columns is-multiline">
                @foreach ($portfolios as $portfolio)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('portfolios.show', $portfolio) }}">{{ $portfolio->name }}</a>
                            </h2>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $portfolios->links() }}
        @else
            <p><i>@lang('portfolios.index.empty')</i></p>
        @endif
    </div>
@endsection
