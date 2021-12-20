@extends('layouts.app')

@section('content')
    <div class="p-form">
        <div class="c-title c-title__form">{{ __('Register') }}</div>
        <div class="c-form">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <label for="name">{{ __('Name') }}</label>
                    <div>
                        <input id="name" type="text"
                               class="c-form__input form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="c-invalid__feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email"
                               class="c-form__input form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="c-invalid__feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password">{{ __('Password') }}</label>

                    <div>
                        <input id="password" type="password"
                               class="c-form__input form-control @error('password') is-invalid @enderror"
                               name="password"
                               required
                               autocomplete="new-password">

                        @error('password')
                        <span class="c-invalid__feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password-confirm"
                    >{{ __('Confirm Password') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="c-form__input form-control"
                               name="password_confirmation"
                               required autocomplete="new-password">
                    </div>
                </div>


                <div class="c-button c-button__form">
                    <div>
                        <button type="submit">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
