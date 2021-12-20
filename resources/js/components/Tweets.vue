<template>
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">予約ツイート登録</div>

                <div class="c-form">
                    <form method="POST" @submit="checkForm">
                        <input type="hidden" name="_token" v-bind:value="csrf">
                        <div>
                            <div>
                            <span class="c-invalid__feedback" role="alert" v-if="!account">
                                <strong>アカウントを選択してください</strong>
                            </span>
                            </div>

                            <div class="c-select">
                                <label for="favorites"> Twitterアカウント </label>
                                <select class="c-select__expand" name="account_id" @change="changeScreenName" v-model="account">
                                    <option v-for="(account,key) in accounts" v-bind:value="account.id">
                                        {{ account.screen_name }}
                                    </option>
                                </select>
                                <div class="c-select__expand--arrow"></div>
                            </div>

                            <div>
                                <input id="favorites" type="text"
                                       class="c-form__input form-control"
                                       name="tweet" v-bind:value="keyword" required
                                       autofocus>
                            </div>
                            <div>
                                <input id="" type="datetime-local"
                                       class="c-form__input form-control"
                                       name="reserved_at" v-bind:value="time"
                                       autocomplete="reserved_at" autofocus required>
                            </div>
                            <div>
                            </div>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form" v-if="keyword != null">
                                <div>
                                    <button type="submit" formaction="/twitter/tweets/edit">
                                        更新する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form" v-else>
                                <div>
                                    <button type="submit" formaction="/twitter/tweets/new">
                                        登録する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form" v-if="keyword  != null">
                                <div>
                                    <button type="submit" formaction="/twitter/tweets/delete">
                                        削除する
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
            axios.get('/twitter/tweets/json/tweets', {
                params: {
                    id: e.target.value
                }
            }).then(response => {
                this.keyword = null;
                this.time = null;

                this.keyword = response.data[0].tweet;
                let time = response.data[0].reserved_at;
                let timeJs = new Date(time);
                this.time = toDateIso(timeJs)

                function toDateIso(timeJs) {
                    let shift = timeJs.getTime() + 9 * 60 * 60 * 1000;
                    let timeLocal = new Date(shift).toISOString().split('.')[0];
                    return timeLocal;
                }
            });
        },
        checkForm: function (e) {
            if (this.account) {
                return true;
            }

            this.errors = [];

            if (!this.account) {
                this.errors.push('アカウントを選択してください');
            }
            e.preventDefault();
        },
        datetimepicker: function (e) {
            $('#target').datetimepicker();
        }
    },
    data: function () {
        return {
            accounts: [],
            keyword: null,
            time: null,
            errors: [],
            account: null,
            reserved: null
        }
    }
}
</script>


