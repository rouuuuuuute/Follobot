<!doctype html>
<!-- 親テンプレートを作成 -->

<!--言語を取得と'-'の置き換え-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <!-- レスポンシブデザインの準備 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 子テンプレートでsection('title')があるかどうかで表示をわけている -->
    @hasSection('title')
        <title>@yield('title') | 神ったー</title>
    @else
        <title>{{ config('app.name') }}</title>
@endif

<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap"
          rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<!-- ヘッダーのテンプレート -->
@section('header')
    <header id="l-header">
        <h1 class="c-title"><a class="c-menu__link" href="/welcome">Twitterデータを利用した集客サービス|神ったー</a></h1>
        <div class="c-menu__sp js-toggle-sp-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav class="js-toggle-sp-menu-target">
            <ul class="c-menu">
                <!-- ToDo href変える-->
                @if (Route::has('register'))
                    @auth
                        <li class="c-menu__item js-toggle-sp-menu-target">
                            <a class="c-menu__link" href="{{ route('home') }}">マイページ</a></li>
                        <div>
                            <li class="c-menu__item js-toggle-sp-menu-target">
                                <a class="c-menu__link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('ログアウト') }}
                                </a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="/howto">使い方</a></li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('home') }}">自動機能開始</a></li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('twitter.accounts') }}">Twitterアカウント</a></li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('twitter.followkeywords') }}">「自動フォロー」キーワード</a></li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('twitter.favorites') }}">「自動いいね」キーワード</a></li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('twitter.tweets') }}">「自動ツイート」</a></li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('twitter.targets') }}">ターゲットアカウント</a></li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('home.profile') }}">プロフィール</a></li>
                    @else
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link" href="/welcome">{{ __('TOP') }}</a></li>
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                    href="{{ route('register') }}">{{ __('まずは無料登録') }}</a></li>
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                    href="{{ route('login') }}">{{ __('ログイン') }}</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </nav>
    </header>
@show

@if ( session ('flash_message'))
<div class="c-arelt" role="alert">
    <p>{{ session ('flash_message')}}</p>
</div>
@endif

<main id="l-main">
    @yield('content')
    @yield('sidebar')
</main>


<!-- フッターのテンプレート -->
@section('footer')
    <footer id="l-footer">
        <div class="p-footer">
            <p class="p-footer__link"><a class="c-footer" href="">プライバシーポリシー</a></p>
            <p class="p-footer__link"><a class="c-footer" href="">サイトご利用規約</a></p>
        </div>
        <div>
            <p>Copyright ©kamitter. All Rights Reserved</p>
        </div>
    </footer>
@show

<!-- Scripts -->
<script src="{{ asset('js/bundle.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
    $(function () {
        // SPメニュー
        $('.js-toggle-sp-menu').on('click', function () {
            $(this).toggleClass('active');
            $('.js-toggle-sp-menu-target').toggleClass('active');
        });

        $('.js-toggle-sp-menu-target').on('click', function () {
            $(this).toggleClass('active');
        });
    });
</script>

</body>

</html>
