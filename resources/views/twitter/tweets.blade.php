@extends('layouts.app')

@section('content')
    <article class="p-main">
        <div class="p-form">
            <div class="c-title c-title__form">{{ __('Tweets') }}</div>
            <div class="c-form">
                <form method="POST" action="{{ route('twitter.tweets.create') }}">
                    @csrf
                    <div>
                        <label for="name">{{ __('TwitterAccounts:')}}</label>
                            <select name="screen_name">
                                <option value="">アカウントを選択してください</option>
                                @foreach( $screen_names as $screen_name )
                                    <option value="{{ $screen_name }}">{{ $screen_name}}</option>
                                @endforeach
                            </select>
                        <div>
                            <input id="" type="text"
                                   class="c-form__input form-control @error('tweet') is-invalid @enderror"
                                   name="tweet" value="{{ old('tweet') }}" required autocomplete="tweet" autofocus>
                            @error('tweet')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div>
                            <input id="" type="datetime-local"
                                   class="c-form__input form-control @error('reserved_at') is-invalid @enderror"
                                   name="reserved_at" value="{{ old('reserved_at') }}" required
                                   autocomplete="reserved_at" autofocus>

                            @error('reserved_at')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
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
                                    {{ __('Delete') }}
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
