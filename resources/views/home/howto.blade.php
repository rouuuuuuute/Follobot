@extends('layouts.app')

@section('content')
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">使い方</div>
                <div class="c-form">
                    <div class="c-form__text">
                        <p class="c-top__heading">STEP1</p>
                        <p class="c-top__heading">Twitterアカウントを登録</p>
                        <p class="c-top__text">ユーザーが所有しているTwitterアカウントを登録</p>
                        <p class="c-top__text">最大10アカウントまで登録可能</p>
                    </div>
                    <div class="c-form__text">
                        <p class="c-top__heading">STEP2</p>
                        <p class="c-top__heading">ターゲットアカウント登録</p>
                        <p class="c-top__text">ここに登録したアカウントのフォロワーから</p>
                        <p class="c-top__text">ユーザーを検索する</p>
                        <p class="c-top__text">対象のアカウントの@以下を入力する</p>
                    </div>
                    <div class="c-form__text">
                        <p class="c-top__heading">STEP3</p>
                        <p class="c-top__heading">フォローキーワードを登録</p>
                        <p class="c-top__text">ツイッターユーザーのプロフィールから検索するため</p>
                        <p class="c-top__text">検索したいキーワードを登録する</p>
                        <p class="c-top__text">キーワードとマッチしたユーザーをフォロー</p>
                        <p class="c-top__text">キーワードは、AND,OR,NOT検索も可能</p>
                        <p class="c-top__text">※日本人ユーザーのみフォローする</p>
                    </div>
                    <div class="c-form__text">
                        <p class="c-top__heading">STEP4</p>
                        <p class="c-top__heading">いいねキーワードを登録</p>
                        <p class="c-top__text">最新つぶやきから検索するため</p>
                        <p class="c-top__text">検索したいキーワードを登録する</p>
                        <p class="c-top__text">キーワードとマッチしたつぶやきをフォロー</p>
                        <p class="c-top__text">キーワードは、AND,OR,NOT検索も可能</p>
                    </div>
                    <div class="c-form__text">
                        <p class="c-top__heading">STEP5</p>
                        <p class="c-top__heading">ツイートを登録</p>
                        <p class="c-top__text">144文字以内でツイートを登録</p>
                        <p class="c-top__text">予約時間を入力することで</p>
                        <p class="c-top__text">自動機能実行中に自動で投稿される</p>
                    </div>
                    <div class="c-form__text">
                        <p class="c-top__heading">FINAL STEP</p>
                        <p class="c-top__heading">自動機能開始</p>
                        <p class="c-top__text">アカウントを選択し</p>
                        <p class="c-top__text">開始ボタンを押すことで自動機能実行</p>
                        <p class="c-top__text">注意事項</p>
                        <p class="c-top__text">自動機能実行中に</p>
                        <p class="c-top__text">ブラウザ遷移したり</p>
                        <p class="c-top__text">画面を閉じると</p>
                        <p class="c-top__text">自動機能が停止される</p>
                    </div>

                </div>
            </div>
        </article>
    </div>

@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection
