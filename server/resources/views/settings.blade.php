@extends('layout')

@section('title', __('settings.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('settings') }}">@lang('settings.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('settings.title')</h1>

    @if (session('message'))
        <div class="notification is-success">
            <button class="delete"></button>
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Change details form -->
    <form class="box" method="POST" action="{{ route('settings.change_details') }}">
        @csrf

        <h2 class="title is-4">@lang('settings.change_details_title')</h2>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('settings.firstname')</label>

                    <div class="control">
                        <input class="input @error('firstname') is-danger @enderror" type="text" id="firstname" name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}" autofocus required>
                    </div>

                    @error('firstname')
                        <p class="help is-danger">{{ $errors->first('firstname') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="insertion">@lang('settings.insertion')</label>

                    <div class="control">
                        <input class="input @error('insertion') is-danger @enderror" type="text" id="insertion" name="insertion" value="{{ old('insertion', Auth::user()->insertion) }}">
                    </div>

                    @error('insertion')
                        <p class="help is-danger">{{ $errors->first('insertion') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('settings.lastname')</label>

                    <div class="control">
                        <input class="input @error('lastname') is-danger @enderror" type="text" id="lastname" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}" required>
                    </div>

                    @error('lastname')
                        <p class="help is-danger">{{ $errors->first('lastname') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="gender">@lang('settings.gender')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('gender') is-danger @enderror">
                            <select id="gender" name="gender" required>
                                <option value="{{ App\Models\User::GENDER_MALE }}" @if (App\Models\User::GENDER_MALE == old('gender', Auth::user()->gender)) selected @endif>
                                    @lang('settings.gender_male')
                                </option>

                                <option value="{{ App\Models\User::GENDER_FEMALE }}" @if (App\Models\User::GENDER_FEMALE == old('gender', Auth::user()->gender)) selected @endif>
                                    @lang('settings.gender_female')
                                </option>

                                <option value="{{ App\Models\User::GENDER_OTHER }}" @if (App\Models\User::GENDER_OTHER == old('gender', Auth::user()->gender)) selected @endif>
                                    @lang('settings.gender_other')
                                </option>
                            </select>
                        </div>
                    </div>

                    @error('gender')
                        <p class="help is-danger">{{ $errors->first('gender') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="birthday">@lang('settings.birthday')</label>

                    <div class="control">
                        <input class="input @error('birthday') is-danger @enderror" type="date" id="birthday" name="birthday" value="{{ old('birthday', Auth::user()->birthday) }}" required>
                    </div>

                    @error('birthday')
                        <p class="help is-danger">{{ $errors->first('birthday') }}</p>
                    @enderror
                </div>
            </div>
        </div>


        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="email">@lang('settings.email')</label>

                    <div class="control">
                        <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    @error('email')
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="phone">@lang('settings.phone')</label>

                    <div class="control">
                        <input class="input @error('phone') is-danger @enderror" type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                    </div>

                    @error('phone')
                        <p class="help is-danger">{{ $errors->first('phone') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="address">@lang('settings.address')</label>

                    <div class="control">
                        <input class="input @error('address') is-danger @enderror" type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}" required>
                    </div>

                    @error('address')
                        <p class="help is-danger">{{ $errors->first('address') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="postcode">@lang('settings.postcode')</label>

                    <div class="control">
                        <input class="input @error('postcode') is-danger @enderror" type="text" id="postcode" name="postcode" value="{{ old('postcode', Auth::user()->postcode) }}" required>
                    </div>

                    @error('postcode')
                        <p class="help is-danger">{{ $errors->first('postcode') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="city">@lang('settings.city')</label>

                    <div class="control">
                        <input class="input @error('city') is-danger @enderror" type="text" id="city" name="city" value="{{ old('city', Auth::user()->city) }}" required>
                    </div>

                    @error('city')
                        <p class="help is-danger">{{ $errors->first('city') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="country">@lang('settings.country')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('country') is-danger @enderror">
                            <select id="country" name="country" required>
                                @foreach (\App\Models\User::COUNTRIES as $country)
                                    <option {{ $country == old('country', Auth::user()->country) ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @error('country')
                        <p class="help is-danger">{{ $errors->first('country') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('settings.change_details_button')</button>
            </div>
        </div>
    </form>

    <!-- Change password form -->
    <form class="box" method="POST" action="{{ route('settings.change_password') }}">
        @csrf

        <h2 class="title is-4">@lang('settings.change_password_title')</h2>

        <div class="field">
            <label class="label" for="current_password">@lang('settings.current_password')</label>

            <div class="control">
                <input class="input @error('current_password') is-danger @enderror" type="password" id="current_password" name="current_password" required>
            </div>

            @error('current_password')
                <p class="help is-danger">{{ $errors->first('current_password') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password">@lang('settings.password')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password" name="password" required>
            </div>

            @error('password')
                <p class="help is-danger">{{ $errors->first('password') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password_confirmation">@lang('settings.password_confirmation')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('settings.change_password_button')</button>
            </div>
        </div>
    </form>
@endsection
