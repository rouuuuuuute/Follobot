<template>
    <div>
    <aside class="p-sidebar">
        <!-- ToDO サイドバーの表示項目は、Vueで切り替える？→プロフィール押した後スライドでツイッターアカウントの表示いれる？-->
        <section class="c-sidebar c-menu">
            <div>
                <h2 class="c-title c-title__sidebar">コンテンツ</h2>
                <div class="c-sidebar__top">
                    <a class="c-menu__link" href="/twitter/accounts">Twitterアカウント</a>
                    <a class="c-menu__link" href="/twitter/keywords/follow">「自動フォロー」キーワード</a>
                    <a class="c-menu__link" href="/twitter/keywords/favorites">「自動いいね」キーワード</a>
                    <a class="c-menu__link" href="/twitter/tweets">「自動ツイート」</a>
                    <a class="c-menu__link" href="/home">プロフィール</a>
                    <a class="c-menu__link" href="/twitter/targets">ターゲットアカウント</a>
                </div>
            </div>
        </section>

        <section class="c-sidebar c-sidebar__middle">
            <h2 class="c-title c-title__sidebar">サービス利用状況</h2>
            <p>対象アカウント アカウント複数の場合、切り替えられるようにする</p>
            <p>対象アカウントの状況によって起動中か停止中か凍結中かを切り替える</p>
            <p>対象アカウントの表示によって起動後フォロー数を表示</p>
            <p>フォローキーワード表示</p>
            <p>いいねキーワード表示</p>
            <p>同上で起動後フォロワー数</p>
            <p>同上で起動後自動いいね数</p>
        </section>

        <section class="c-sidebar c-sidebar__middle">
        </section>

        <section class="c-sidebar">
            <div class="c-sidebar__bottom">
                <h3 class="c-title c-title__sidebar">自動フォロー</h3>
                <div>
                    <a class="c-button c-button__sidebar">開始</a>
                    <a class="c-button c-button__sidebar">停止</a>
                </div>
            </div>
            <div class="c-sidebar-bottom">
                <h3 class="c-title c-title__sidebar">自動いいね</h3>
                <div>
                    <a class="c-button c-button__sidebar">開始</a>
                    <a class="c-button c-button__sidebar">停止</a>
                </div>
            </div>
        </section>
    </aside>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
