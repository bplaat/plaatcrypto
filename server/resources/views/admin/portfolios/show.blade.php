@extends('layout')

@section('title', __('admin/portfolios.show.title', ['portfolio.name' => $portfolio->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.portfolios.index') }}">@lang('admin/portfolios.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.portfolios.show', $portfolio) }}">{{ $portfolio->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $portfolio->name }}</h1>

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.portfolios.edit', $portfolio) }}">@lang('admin/portfolios.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.portfolios.delete', $portfolio) }}">@lang('admin/portfolios.show.delete')</a>
        </div>
    </div>

    <!-- Portfolio users -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/portfolios.show.users')</h2>

        @if ($portfolioUsers->count() > 0)
            {{ $portfolioUsers->links() }}

            <div class="columns is-multiline">
                @foreach ($portfolioUsers as $user)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">
                                <a href="{{ route('admin.users.show', $user) }}">{{ $user->name() }}</a>

                                @if ($user->pivot->role == App\Models\PortfolioUser::ROLE_VIEWER)
                                    <span class="tag is-pulled-right is-success">@lang('admin/portfolios.show.users_role_viewer')</span>
                                @endif

                                @if ($user->pivot->role == App\Models\PortfolioUser::ROLE_ONWER)
                                    <span class="tag is-pulled-right is-info">@lang('admin/portfolios.show.users_role_onwer')</span>
                                @endif
                            </h3>

                            @if ($user->pivot->role != App\Models\PortfolioUser::ROLE_ONWER || $portfolioOnwers->count() > 1)
                                <div class="buttons">
                                    @if ($user->pivot->role == App\Models\PortfolioUser::ROLE_ONWER)
                                        <a class="button is-success" href="{{ route('admin.portfolios.users.update', [$portfolio, $user]) }}?role={{ App\Models\PortfolioUser::ROLE_VIEWER }}">@lang('admin/portfolios.show.users_make_viewer_button')</a>
                                    @else
                                        <a class="button is-info" href="{{ route('admin.portfolios.users.update', [$portfolio, $user]) }}?role={{ App\Models\PortfolioUser::ROLE_ONWER }}">@lang('admin/portfolios.show.users_make_onwer_button')</a>
                                    @endif

                                    <a class="button is-danger" href="{{ route('admin.portfolios.users.delete', [$portfolio, $user]) }}">@lang('admin/portfolios.show.users_remove_button')</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $portfolioUsers->links() }}
        @else
            <p><i>@lang('admin/portfolios.show.users_empty')</i></p>
        @endif

        @if ($portfolioUsers->count() != $users->count())
            <form method="POST" action="{{ route('admin.portfolios.users.create', $portfolio) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('user_id') is-danger @enderror">
                            <select id="user_id" name="user_id" required>
                                <option selected disabled>
                                    @lang('admin/portfolios.show.users_field')
                                </option>

                                @foreach ($users as $user)
                                    @if (!$portfolioUsers->pluck('id')->contains($user->id))
                                        <option value="{{ $user->id }}"  @if ($user->id == old('user_id')) selected @endif>
                                            {{ $user->name() }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <div class="select is-fullwidth @error('role') is-danger @enderror">
                            <select id="role" name="role" required>
                                <option value="{{ App\Models\PortfolioUser::ROLE_VIEWER }}" @if (App\Models\PortfolioUser::ROLE_VIEWER == old('role', App\Models\PortfolioUser::ROLE_VIEWER)) selected @endif>
                                    @lang('admin/portfolios.show.users_role_field_viewer')
                                </option>

                                <option value="{{ App\Models\PortfolioUser::ROLE_ONWER }}" @if (App\Models\PortfolioUser::ROLE_ONWER == old('role', App\Models\PortfolioUser::ROLE_VIEWER)) selected @endif>
                                    @lang('admin/portfolios.show.users_role_field_onwer')
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/portfolios.show.users_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
