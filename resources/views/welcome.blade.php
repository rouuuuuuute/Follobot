@extends('layouts.app')

@section('title','Twitterデータを利用した集客サービス')

@section('header')
    @parent
@endsection

@section('content')
    <article id="l-main__article">
        <section class="p-top">
            <section class="p-top__msg">
                <div class="c-top">
                    <h1 class="c-top__theme">集客に”イノベーション”を</h1>
                    <img class="c-img__logo" src="{{ asset('images/logo-Twitter.png') }}" alt="">
                </div>
                <div class="c-top">
                    <p class="c-top__text">日本最大級のSNS利用者数を誇るTwitter</p>
                    <p class="c-top__text">匿名性・拡散性が高く</p>
                    <p class="c-top__text">顧客にダイレクトにリーチできる</p>
                    <p class="c-top__text">企業アカウント、インフルエンサー...etc</p>
                    <p class="c-top__text">あらゆる業種・職種が集客システムの利用を始めている</p>
                    <p class="c-top__text">さぁ、あなたも</p>
                </div>
                @if (Route::has('register'))
                    <div class="c-top">
                        @auth
                            <a class="c-button c-button__top c-menu__link" href="{{ route('home') }}">マイページへ</a>
                        @else
                            <a class="c-button c-button__top  c-menu__link"
                               href="{{ route('register') }}">無料でフォロワーを増やす</a>
                        @endauth
                    </div>
                @endif
            </section>
            <section class="p-top__img">
                <div class="c-img">
                    <img class="c-img__sp" src="{{ asset('images/top-sp.png') }}" alt="">
                </div>
                <div class="c-img">
                    <img class="c-img__follow" src="{{ asset('images/top-follow.png') }}" alt="">
                    <img class="c-img__arrow" src="{{ asset('images/top-arrow.png') }}" alt="">
                </div>
                <div class="c-img">
                    <img class="c-img__human" src="{{ asset('images/top-man.png') }}" alt="">
                    <img class="c-img__human c-img__human--female" src="{{ asset('images/top-woman.png') }}" alt="">
                    <img class="c-img__human" src="{{ asset('images/top-man2.png') }}" alt="">
                </div>
            </section>
        </section>
        <section class="p-prof">
            <section class="">
                <div class="c-top">
                    <h2 class="c-top__heading">神ったーとは</h2>
                    <p class="c-top__text">Twitter社から提供されるデータを使って<br>お客様のアカウントのフォロワーを増やし<br>ターゲットからの認知度をあげるツールです</p>
                </div>
            </section>
            <section class="">
                <div class="c-top">
                    <h2 class="c-top__heading">なぜTwitterなのか</h2>
                    <p class="c-top__text">日本ではあらゆる世代でTwitterが活用されており<br>日本でSNS利用者数が最大規模を誇るのはTwitterだけ！</p>
                </div>
                <div class="c-top">
                    <h2 class="c-top__heading">こんなことで困っていませんか</h2>
                    <p class="c-top__text">お客様のアカウントの認知度が低い</p>
                    <p class="c-top__text">誰に訴求できたかわからない</p>
                    <p class="c-top__text">フォロワーを増やす時間がない</p>
                    <p class="c-top__text">神ったーなら解決できます！</p>
                </div>
            </section>
        </section>
        <section id="p-service">
            <section class="c-top">
                <div>
                    <h2 class="c-top__heading">サービス</h2>
                </div>
                <div class="c-card">
                    <div class="c-card__service">
                        <h3 class="c-card__title">自動フォロー</h3>
                        <p class="c-top__text">ユーザーを自動で検索</p>
                        <p class="c-top__text">自動でフォロー</p>
                        <p class="c-top__text">アクティブユーザーのみにターゲット</p>
                        <p class="c-top__text">1日で最大1000人も<br>フォロワーが増えることも！？</p>
                    </div>
                    <div class="c-card__service">
                        <h3 class="c-card__title">自動いいね</h3>
                        <p class="c-top__text">最新のつぶやきを検索</p>
                        <p class="c-top__text">ツイートを自動でいいね</p>
                        <p class="c-top__text">ユーザーからの認知度UP!</p>
                        <p class="c-top__text">潜在顧客に直接アプローチ！</p>
                    </div>
                    <div class="c-card__service">
                        <h3 class="c-card__title">自動ツイート</h3>
                        <p class="c-top__text">内容と日程を事前に設定</p>
                        <p class="c-top__text">自動で投稿</p>
                        <p class="c-top__text">最新情報をいちはやくツイート！</p>
                    </div>
                </div>
            </section>
            <section id="p-price" class="">
                <div class="c-top">
                    <h2 class="c-top__heading">料金プラン</h2>
                    <p class="c-top__heading">いまなら月額無料！</p>
                    <p class="c-top__text">まずは無料登録へ</p>
                </div>
            </section>
        </section>
    </article>
@endsection



@section('footer')
    @parent
@endsection
