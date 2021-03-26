@extends('layout')

@section('title', __('auth.register.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('auth.register') }}">@lang('auth.register.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('auth.register.header')</h1>

    <form method="POST">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('auth.register.firstname')</label>

                    <div class="control">
                        <input class="input @error('firstname') is-danger @enderror" type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" autofocus required>
                    </div>

                    @error('firstname')
                        <p class="help is-danger">{{ $errors->first('firstname') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="insertion">@lang('auth.register.insertion')</label>

                    <div class="control">
                        <input class="input @error('insertion') is-danger @enderror" type="text" id="insertion" name="insertion" value="{{ old('insertion') }}">
                    </div>

                    @error('insertion')
                        <p class="help is-danger">{{ $errors->first('insertion') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('auth.register.lastname')</label>

                    <div class="control">
                        <input class="input @error('lastname') is-danger @enderror" type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
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
                    <label class="label" for="gender">@lang('auth.register.gender')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('gender') is-danger @enderror">
                            <select id="gender" name="gender" required>
                                <option value="{{ App\Models\User::GENDER_MALE }}" @if (App\Models\User::GENDER_MALE == old('gender', App\Models\User::GENDER_MALE)) selected @endif>
                                    @lang('auth.register.gender_male')
                                </option>

                                <option value="{{ App\Models\User::GENDER_FEMALE }}" @if (App\Models\User::GENDER_FEMALE == old('gender', App\Models\User::GENDER_MALE)) selected @endif>
                                    @lang('auth.register.gender_female')
                                </option>

                                <option value="{{ App\Models\User::GENDER_OTHER }}" @if (App\Models\User::GENDER_OTHER == old('gender', App\Models\User::GENDER_MALE)) selected @endif>
                                    @lang('auth.register.gender_other')
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
                    <label class="label" for="birthday">@lang('auth.register.birthday')</label>

                    <div class="control">
                        <input class="input @error('birthday') is-danger @enderror" type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
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
                    <label class="label" for="email">@lang('auth.register.email')</label>

                    <div class="control">
                        <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    @error('email')
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="phone">@lang('auth.register.phone')</label>

                    <div class="control">
                        <input class="input @error('phone') is-danger @enderror" type="tel" id="phone" name="phone" value="{{ old('phone') }}">
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
                    <label class="label" for="address">@lang('auth.register.address')</label>

                    <div class="control">
                        <input class="input @error('address') is-danger @enderror" type="text" id="address" name="address" value="{{ old('address') }}" required>
                    </div>

                    @error('address')
                        <p class="help is-danger">{{ $errors->first('address') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="postcode">@lang('auth.register.postcode')</label>

                    <div class="control">
                        <input class="input @error('postcode') is-danger @enderror" type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" required>
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
                    <label class="label" for="city">@lang('auth.register.city')</label>

                    <div class="control">
                        <input class="input @error('city') is-danger @enderror" type="text" id="city" name="city" value="{{ old('city') }}" required>
                    </div>

                    @error('city')
                        <p class="help is-danger">{{ $errors->first('city') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="country">@lang('auth.register.country')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('country') is-danger @enderror">
                            <select id="country" name="country" required>
                                @foreach (\App\Models\User::COUNTRIES as $country)
                                    <option {{ $country == old('country', 'Netherlands') ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
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

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="password">@lang('auth.register.password')</label>

                    <div class="control">
                        <input class="input @error('password') is-danger @enderror" type="password" id="password" name="password" required>
                    </div>

                    @error('password')
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="password_confirmation">@lang('auth.register.password_confirmation')</label>

                    <div class="control">
                        <input class="input @error('password') is-danger @enderror" type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('auth.register.button')</button>
            </div>
        </div>
    </form>
@endsection
