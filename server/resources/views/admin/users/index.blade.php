@extends('layout')

@section('title', __('admin/users.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.index') }}">@lang('admin/users.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/users.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.users.create') }}">@lang('admin/users.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/users.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/users.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($users->count() > 0)
            {{ $users->links() }}

            <div class="columns is-multiline">
                @foreach ($users as $user)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('admin.users.show', $user) }}">{{ $user->name() }}</a>

                                @if ($user->role == App\Models\User::ROLE_NORMAL)
                                    <span class="tag is-pulled-right is-success">@lang('admin/users.index.role_normal')</span>
                                @endif

                                @if ($user->role == App\Models\User::ROLE_ADMIN)
                                    <span class="tag is-pulled-right is-danger">@lang('admin/users.index.role_admin')</span>
                                @endif
                            </h2>

                            <p><a class="tag" href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $users->links() }}
        @else
            <p><i>@lang('admin/users.index.empty')</i></p>
        @endif
    </div>
@endsection
