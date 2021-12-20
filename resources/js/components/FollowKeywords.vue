<template>
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">フォローキーワード登録</div>

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
                                <label for="keyword"> Twitterアカウント </label>
                                <select class="c-select__expand" name="account_id" @change="changeScreenName" v-model="account">
                                    <option v-for="(account,key) in accounts" v-bind:value="account.id">
                                        {{ account.screen_name }}
                                    </option>
                                </select>
                                <div class="c-select__expand--arrow"></div>
                            </div>

                            <div>
                                <input id="keyword" type="text"
                                       class="c-form__input form-control"
                                       name="keyword" v-bind:value="keyword" required
                                       autofocus placeholder="入力してください" >
                            </div>
                            <div>
                                <input type="checkbox" v-model="check">AND,OR,NOT条件を追加する
                                <select name="logic" v-if="check">
                                    <option value="AND">AND</option>
                                    <option value="OR">OR</option>
                                    <option value="NOT">NOT</option>
                                </select>
                                <input type="text"
                                       class="c-form__input form-control "
                                       name="keyword2" v-bind:value="keyword2"
                                       autofocus v-if="check">
                            </div>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form" v-if="keyword != null">
                                <div>
                                    <button type="submit" formaction="/twitter/keywords/follow/edit">
                                        更新する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form" v-else>
                                <div>
                                    <button type="submit" formaction="/twitter/keywords/follow/new">
                                        登録する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form" v-if="keyword != null">
                                <div>
                                    <button type="submit" formaction="/twitter/keywords/follow/delete">
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
            axios.get('/twitter/keywords/follow/json/keywords', {
                params: {
                    id: e.target.value
                }
            }).then(response => {
                this.keyword = null;
                this.logic = null;
                this.keyword2 = null;

                this.keyword = response.data[0].keyword;
                this.logic = response.data[0].logic;
                this.keyword2 = response.data[0].keyword2;
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
            keyword: null,
            logic: [],
            keyword2: [],
            errors: [],
            account: null,
            check: false
        }
    }
}
</script>
