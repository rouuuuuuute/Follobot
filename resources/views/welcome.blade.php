@extends('layouts.app')

@section('title','Twitterデータを利用した集客サービス')

@section('content')
    <section class="p-top">
        <section class="p-top__msg">
            <div class="c-top">
                <h2 class="c-top__title">SNSデータ分析</h2>
                <h2 class="c-top__title c-top__title--cross">×</h2>
                <h2 class="c-top__title">集客</h2>
            </div>
            <div class="c-top">
                <h3 class="c-top__theme">集客に”イノベーション”を</h3>
            </div>
            <div class="c-top">
                <p class="c-top__text">日本最大級のSNS利用者数を誇るTwitter</p>
                <p class="c-top__text">拡散性の高さ、匿名性による生の声の拾いやすさを</p>
                <p class="c-top__text">集客に活かさない手はない</p>
                <p class="c-top__text">企業アカウント、インフルエンサー...etc</p>
                <p class="c-top__text">あらゆる業種・職種のアカウントが</p>
                <p class="c-top__text">集客システムの利用を始めている</p>
                <p class="c-top__text">さぁ、あなたも</p>
            </div>
            <!-- ToDo href変える-->
            @if (Route::has('register'))
                <div class="c-top">
                    @auth
                        <a class="c-top__register c-menu__link" href="{{ route('home') }}">マイページへ</a>
                    @else
                        <a class="c-top__register c-menu__link" href="{{ route('register') }}">無料でフォロワーを増やす</a>
                    @endauth
                </div>
            @endif
        </section>
        <section class="p-top__img">
            <div class="c-img">
                <img class="c-img__sp" src="{{ asset('images/top-sp.png') }}" alt="">
            </div>
            <div class="c-img">
                <img class="c-img__arrow" src="{{ asset('images/top-arrow.png') }}" alt="">
            </div>
            <div class="c-img">
                <img class="c-img__human" src="{{ asset('images/top-man.png') }}" alt="">
                <img class="c-img__human c-img__human--female" src="{{ asset('images/top-woman.png') }}" alt="">
                <img class="c-img__human" src="{{ asset('images/top-man2.png') }}" alt="">
            </div>
        </section>
        <section class="p-top__txt">
            <p class="c-top__follow">5000人</p>
        </section>
    </section>
    <section class="p-prof">
        <div>
            <h1>神ったーとは</h1>
            <p>Twitterから提供されるデータを使ってお客様のアカウントの認知度をあげるツールです</p>
        </div>
        <div>
            <h1>なぜTwitter？</h1>
            <p>日本ではSNSの利用者が最大なのがTwitterだから！</p>
        </div>
        <div>
            <h2>こんなことで困っていませんか</h2>
            <div>
                <h3>お客様のアカウントの認知度が低い</h3>
            </div>
            <div>
                <h3>誰に訴求できたかわからない</h3>
            </div>
            <div>
                <h3>フォロワーを増やす時間がない</h3>
            </div>
            <div>
                <h3>神ったーなら解決できます！</h3>
            </div>
        </div>
    </section>
    <section id="p-service">
        <div>
            <h1>サービス</h1>
        </div>
        <div>
            <h2>自動フォロー</h2>
            <p>事前に登録したキーワードを使って、Twitterのデータを分析</p>
            <p>興味関心を持っているユーザーをフォロー</p>
            <p>ユーザーからの認知度UP!</p>
        </div>
        <div>
            <h2>自動いいね</h2>
            <p>事前に登録したキーワードをつぶやいているツイートを自動いいね</p>
            <p></p>
        </div>
        <div>
            <h2>自動ツイート</h2>
            <p>事前に予約した時間帯につぶやいて商品発表や重大発表を告知！</p>
        </div>
        <div>
            <h2>その他</h2>
            <h3>複数アカウント登録可能！</h3>
            <h3>凍結時の対策も安心！</h3>
        </div>
    </section>
    <section id="p-price">
        <h1>料金プラン</h1>
        <h2>これだけ使えて、いまなら月額無料！</h2>
    </section>
@endsection

