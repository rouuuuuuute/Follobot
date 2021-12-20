@extends('layouts.app')

@section('content')
    <div class="p-form">
        <div class="c-title c-title__form">{{ __('Reset Password') }}</div>

        <div class="c-form">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row">
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email" class="c-form__input form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                               autofocus>

                        @error('email')
                        <span class="c-invalid__feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password">{{ __('Password') }}</label>

                    <div>
                        <input id="password" type="password"
                               class="c-form__input form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="new-password">

                        @error('password')
                        <span class="c-invalid__feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="c-form__input form-control" name="password_confirmation"
                               required autocomplete="new-password">
                    </div>
                </div>

                <div class="c-button c-button__form">
                    <div>
                        <button type="submit">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
