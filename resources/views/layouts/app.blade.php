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

<!--ToDo jsなので後で下に移動する -->
    <!-- Scripts -->
    <script src="{{ asset('js/bundle.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap"
          rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<!-- ToDo Bodyタグ以下は後でつくる。まずはTOPページから -->
<body>

<!-- ヘッダーのテンプレート -->
@section('header')
    <header id="l-header">
        <h1 class="c-title"><a class="c-menu__link" href="/welcome">Twitterデータを利用した集客サービス|神ったー</a></h1>
        <div class="c-sp__menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav class="p-nav">
            <ul class="c-menu">
                <!-- ToDo href変える-->
                @if (Route::has('register'))
                    @auth
                        <li class="c-menu__item">
                            <a class="c-menu__link" href="{{ route('home') }}">マイページ</a></li>
                        <div>
                            <li class="c-menu__item">
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
                    @else
                        <li class="c-menu__item"><a class="c-menu__link" href="/welcome">{{ __('TOP') }}</a></li>
                        <li class="c-menu__item"><a class="c-menu__link" href="/welcome#p-service">{{ __('サービス') }}</a></li>
                        <li class="c-menu__item"><a class="c-menu__link" href="/welcome#p-price">{{ __('料金') }}</a></li>
                        <li class="c-menu__item"><a class="c-menu__link"
                                                    href="{{ route('register') }}">{{ __('まずは無料登録') }}</a></li>
                        <li class="c-menu__item"><a class="c-menu__link"
                                                    href="{{ route('login') }}">{{ __('ログイン') }}</a>
                        </li>
                    @endauth
                @endif
                <li class="c-menu__item"><a class="c-menu__link" href="">{{ __('問い合わせ') }}</a></li>
            </ul>
        </nav>
    </header>
@show

<main id="l-main">
    @yield('content')
</main>

<!-- フッターのテンプレート -->
@section('footer')
    <footer id="l-footer">
        <div class="p-footer">
            <p><a class="c-footer" href="">プライバシーポリシー</a></p>
            <p><a class="c-footer" href="">サイトご利用規約</a></p>
            <p><a class="c-footer" href="">お問い合わせ</a></p>
        </div>
        <div>
            <p>Copyright ©kamitter. All Rights Reserved</p>
        </div>
    </footer>
@show

</body>
</html>
