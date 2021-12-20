@extends('layouts.app')

@section('content')
    <div class="p-form">
        <div class="c-title c-title__form">{{ __('Login') }}</div>
        <div class="c-form">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email"
                               class="c-form__input form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                               class="c-form__input form-control @error('password') is-invalid @enderror" name="password"
                               required
                               autocomplete="current-password">

                        @error('password')
                        <span class="c-invalid__feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    @if (Route::has('password.request'))
                        <button type="submit"><a href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a></button>
                    @endif
                </div>
                <div class="c-button c-button__form">
                    <div>
                        <button type="submit">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
