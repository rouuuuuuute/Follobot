@extends('layouts.app')

@section('content')
    <article class="p-main">
        <div class="p-form">
            <div class="c-title c-title__form">{{ __('Twitter Targets') }}</div>
            <div class="c-form">
                @for ($i=1 ; $i <= 10; $i++)
                    <form method="POST" action="{{ route('twitter.targets.create') }}">
                        @csrf
                        <div>
                            <label for="name">{{ __('targets').$i }}</label>
                            <div>
                                <input id="keyword" type="text"
                                       class="c-form__input form-control @error('keyword') is-invalid @enderror"
                                       name="keyword" value="{{ old('keyword') }}" required autocomplete="keyword"
                                       autofocus>

                                @error('keyword')
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
                @endfor
            </div>
        </div>
    </article>


@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection
