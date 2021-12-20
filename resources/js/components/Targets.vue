<template>
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">ターゲットアカウント登録</div>

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
                                <label> Twitterアカウント </label>
                                <select class="c-select__expand" name="account_id" @change="changeScreenName" v-model="account">
                                    <option v-for="(account,key) in accounts" v-bind:value="account.id">
                                        {{ account.screen_name }}
                                    </option>
                                </select>
                                <div class="c-select__expand--arrow"></div>
                            </div>

                            <div class="c-select">
                                <label> フォロワーターゲット </label>
                                <select class="c-select__expand" name="target_id" v-model="keyword">
                                    <option v-for="(keyword,key) in keywords" v-bind:value="keyword.id">
                                        {{ keyword.target_name }}
                                    </option>
                                    <option v-bind:value="null">アカウントを登録する</option>
                                </select>
                                <div class="c-select__expand--arrow"></div>
                            </div>

                            <div>
                                <input id="targets" type="text"
                                       class="c-form__input form-control"
                                       name="target_name" v-if="keyword === null" v-bind:value="keyword" required
                                       autofocus placeholder="@以下のアカウント名を記入してください">
                            </div>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form" v-if="keyword === null">
                                <div>
                                    <button type="submit" formaction="/twitter/targets/new">
                                        登録する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form" v-if="keyword !== null">
                                <div>
                                    <button type="submit" formaction="/twitter/targets/delete">
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
            axios.get('/twitter/targets/json/targets', {
                params: {
                    id: e.target.value
                }
            }).then(response => {
                this.keywords = null;

                this.keywords = response.data;
            })
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
        }
    },
    data: function () {
        return {
            accounts: [],
            keywords: [],
            errors: [],
            account: null,
            keyword: null
        }
    }
}
</script>
