@extends('layouts.app')

@section('content')
    <article class="p-main">
        <div class="p-form">
            <div class="c-title c-title__form">{{ __('Profile') }}</div>
            <div class="c-form">
                <form method="POST" action="{{ route('home.edit') }}">
                    @csrf
                    <div>
                        <label for="name">{{ __('Name') }}</label>
                        <div>
                            <input id="name" type="text"
                                   class="c-form__input form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{$name}}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
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
                                   name="email" value="{{ $email }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        @if (Route::has('password.request'))
                            <button type="submit"><a href="{{ route('password.request') }}">
                                    {{ __('Change Your Password?') }}
                                </a></button>
                        @endif
                    </div>


                    <div class="c-button__wrap">
                        <div class="c-button c-button__form">
                            <div>
                                <button type="submit">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                        <div class="c-button c-button__form">
                            <div>
                                <button type="submit">
                                    {{ __('Withdraw') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </article>


@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection






