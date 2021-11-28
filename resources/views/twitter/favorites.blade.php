@extends('layouts.app')

@section('content')
    <article class="p-main">
        <div class="p-form">
            <div class="c-title c-title__form">{{ __('Favorites Keywords') }}</div>

            {{--                    ToDo あとで修正--}}
            <div>
                <p>検索条件を指定することもできます</p>
                <p>AND検索（複数キーワードを両方探す）の場合は、キーワードの間に空白スペースを入れてください</p>
                <p>OR検索（複数キーワードのうち、いずれかを含むものを探す）の場合は、キーワードの間にORを入れてください</p>
                <p>NOT検索（複数キーワードのうち、一方を除外する）の場合は、キーワードの間に-を入れてください</p>
            </div>

            <div class="c-form">
                <form method="POST" action="{{ route('twitter.favorites.create') }}">
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
                                   class="c-form__input form-control @error('favorite_keyword') is-invalid @enderror"
                                   name="favorite_keyword" value="{{ old('favorite_keyword') }}" required autocomplete="favorite_keyword" autofocus>

                            @error('favorite_keyword')
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
