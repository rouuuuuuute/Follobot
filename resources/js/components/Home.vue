<template>
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">自動機能</div>

                <div class="c-form">
                    <form method="GET" name="auto">
                        <div>
                            <div>
                            <span class="c-invalid__feedback" role="alert" v-if="!account">
                                <strong>アカウントを選択してください</strong>
                            </span>
                            </div>
                            <div class="c-select">
                                <label> Twitterアカウント </label>
                                <select class="c-select__expand" name="account_id" @change="changeScreenName"
                                        v-model="account">
                                    <option v-for="(account,key) in accounts" v-bind:value="account.id">
                                        {{ account.screen_name }}
                                    </option>
                                </select>
                                <div class="c-select__expand--arrow"></div>
                            </div>
                            <table class="c-table">
                                <thead>
                                <tr>
                                    <th class="c-table__thead">登録済みキーワード</th>
                                </tr>
                                </thead>
                                <tbody class="c-table__body">
                                <tr>
                                    <th class="c-table__th">「フォロー」：</th>
                                    <td class="c-table__td">
                                        {{ keyword }}
                                    </td>

                                    <td class="c-table__td">
                                        {{ logic }}
                                    </td>

                                    <td class="c-table__td">
                                        {{ keyword2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="c-table__th">「いいね」：</th>
                                    <td class="c-table__td">
                                        {{ favorite }}
                                    </td>
                                    <td class="c-table__td">
                                        {{ favoritelogic }}
                                    </td>
                                    <td class="c-table__td">
                                        {{ favorite2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="c-table__th">「ツイート&予約日時」：</th>
                                    <td class="c-table__td">
                                        {{ tweet }}
                                    </td>
                                    <td class="c-table__td">
                                        {{ reserved }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="c-table__th">ターゲットアカウント：</th>
                                </tr>
                                <tr class="c-table__tr" v-for="(target,key) in targets">
                                    <td class="c-table__td">{{ target.target_name }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form" v-if="automation === true">
                                <div>
                                    <button type="button" @click="submit">
                                        自動機能を開始する
                                    </button>
                                </div>
                            </div>

                            <div class="c-button c-button__form" v-else-if="automation === 'stop'">
                                <div>
                                    <button type="button">
                                        停止しました
                                    </button>
                                </div>
                            </div>

                            <div class="c-button c-button__form" v-else>
                                <div>
                                    <button type="button">
                                        自動機能実行中
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div v-if="errors.length">
                        <h1>以下のエラーを修正してください。</h1>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </article>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        csrf: {
            type: String,
            required: true,
        }
    },
    mounted() {
        this.$nextTick(function () {
            axios.get('/twitter/json/accounts').then(response => {
                this.accounts = response.data;
            })
        })
    },
    methods: {
        changeScreenName: function (e) {
            this.automation = true;
            axios.get('/twitter/keywords/follow/json/keywords', {
                params: {
                    id: e.target.value
                },
            }).then(response => {
                this.keyword = null;
                this.logic = null;
                this.keyword2 = null;

                this.keyword = response.data[0].keyword;
                this.logic = response.data[0].logic;
                this.keyword2 = response.data[0].keyword2;
            })
            axios.get('/twitter/keywords/favorites/json/keywords', {
                params: {
                    id: e.target.value
                }
            }).then(response => {
                this.favorite = null;
                this.favoritelogic = null;
                this.favorite2 = null;

                this.favorite = response.data[0].favorite_keyword;
                this.favoritelogic = response.data[0].logic;
                this.favorite2 = response.data[0].favorite_keyword2;
            })
            axios.get('/twitter/tweets/json/tweets', {
                params: {
                    id: e.target.value
                }
            }).then(response => {
                this.tweet = null;
                this.reserved = null;

                this.tweet = response.data[0].tweet;
                this.reserved = response.data[0].reserved_at;
            });
            axios.get('/twitter/targets/json/targets', {
                params: {
                    id: e.target.value
                }
            }).then(response => {
                this.targets = null;
                this.targets = response.data;
            });
        },

        submit: function (e) {

            //自動機能ボタン実行時に、アカウント選択、フォローキーワード登録、いいねキーワード登録、ターゲット登録がされているか確認。されていなければ、ajaxをとめてエラーを返す
            //自動ツイートは必ずしも登録するわけではないと思うので省いている

            this.errors = [];
            if (!this.account) {
                this.errors.push('アカウントを選択してください');
                e.preventDefault();
                return;
            }

            if (!this.keyword) {
                this.errors.push('自動フォローキーワードを登録してください');
                e.preventDefault();
                return;
            }

            if (!this.favorite) {
                this.errors.push('自動いいねキーワードを登録してください');
                e.preventDefault();
                return;
            }


            if (this.targets.length === 0) {
                this.errors.push('フォロワーターゲットを登録してください');
                e.preventDefault();
                return;
            }

            //自動ツイート投稿
            let tweet_ajax = () => {
                axios.get('/twitter/tweets/post', {
                    params: {
                        id: document.auto.account_id.value
                    }
                });
            }


            //ToDo エラー時（アカウント間違い、フォローキーワード間違い、いいねキーワード間違いのときはメール送って、returnで凍結と同じ処理にする）
            let that = this;

            //自動フォローアンフォローいいね機能
            function follow_ajax(that) {
                axios.get('/twitter/api/search/follower', {
                    params: {
                        id: document.auto.account_id.value
                    }
                }).then(response => {
                    let suspend = response.data.susBool;
                    if (suspend === 0) {
                        that.automation = 'stop';
                        that.errors.push('自動機能を停止しました。詳細はメールをご確認ください');
                        console.log('凍結されている');
                        console.log(suspend);
                        clearInterval(followTimer);
                        clearInterval(tweetTimer);
                    } else {
                        console.log('自動機能実行中');
                    }
                });
            }

            //自動ツイートの予約時間を取得
            let reserved_time = this.reserved;
            let reservedTime = Date.parse(reserved_time);

            //自動ツイートが登録されていれば実行
            //1分毎にif文でUNIXTimeに変換した予約時間と現在時間を比較し、予約時間を超えていたらtweet_ajaxを実行
            //自動機能開始時に過去日に設定していた場合は、すぐに投稿されるようにする
            if (this.tweet) {
                let tweetTimer = setInterval(function () {
                    let date = new Date();
                    let now = date.getTime();
                    if (now > reservedTime) {
                        tweet_ajax();
                        clearInterval(tweetTimer);
                        console.log('reservedTimeが現在時刻より過去のためツイートして中止');
                    } else {
                        console.log('自動ツイート実行中');
                    }
                }, 60000);
            }

            //アカウントが選択されているか確認
            //凍結対策のため20分ごとにfollow_ajaxを実行（自動フォローターゲット作成→自動フォロー→自動アンフォロー→自動いいねの処理になる）
            //凍結された場合はclearIntervalでとめる
            this.automation = false;
            follow_ajax(that);
            let followTimer = setInterval(function () {
                follow_ajax(that);
            }, 1200000);


        }
    },
    data: function () {
        return {
            accounts: [],
            keyword: null,
            logic: null,
            keyword2: null,
            favorite: null,
            favoritelogic: null,
            favorite2: null,
            tweet: null,
            reserved: null,
            targets: null,
            target: null,
            errors: [],
            account: null,
            automation: true,
            ratelimit: []
        }
    }
}
</script>
