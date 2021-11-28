@extends('layouts.app')

{{--ToDo 各ボタンごとにアカウント登録できるようにすること。また、登録したアカウント名が表示されるようにすること。--}}
{{--ToDo アカウントが重複した場合、エラーが出せるようにすること。--}}
@section('content')
    <article class="p-main">
        <div class="p-form">
            <div class="c-title c-title__form">{{ __('Twitter accounts') }}</div>

{{--            ToDo 10個まで登録できるようにするには、どうすればいい？--}}
            @foreach( $screen_names as $screen_name)
                <div class="c-form">
                    <form method="POST" action="{{ route('twitter.accounts.request') }}">
                        @csrf
                        <div>
                                <label for="name">{{ __('accounts').':'.$screen_name }}</label>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form">
                                <div>
                                    <button type="submit">
                                        {{ __('Register Accounts') }}
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
            @endforeach

        </div>
    </article>


@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection



