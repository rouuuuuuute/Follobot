<template>
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">Twitterアカウント連携</div>

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
                                <select class="c-select__expand" name="account_id" v-model="account">
                                    <option v-for="(account,key) in accounts" v-bind:value="account.id">
                                        {{ account.screen_name }}
                                    </option>
                                    <option v-bind:value="'register'" v-if="accounts.length < 10">アカウントを登録する</option>
                                </select>
                                <div class="c-select__expand--arrow"></div>
                            </div>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form" v-if="account === 'register'">
                                <div>
                                    <button type="submit" formaction="/twitter/accounts/request">
                                        登録する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form" v-else>
                                <div>
                                    <button type="submit" formaction="/twitter/accounts/delete">
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
            errors: [],
            account: null
        }
    }
}
</script>
