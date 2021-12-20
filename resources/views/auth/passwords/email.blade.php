@extends('layouts.app')

@section('content')
    <div class="p-form">
        <div class="c-title c-title__form">{{ __('Reset Password') }}</div>

        <div class="c-form">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email" class="c-form__input form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="c-invalid__feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="c-button c-button__form">
                    <div>
                        <button type="submit">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
