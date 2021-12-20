<template>
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">プロフィール</div>

                <div class="c-form">
                    <form method="POST" @submit="checkForm">
                        <input type="hidden" name="_token" v-bind:value="csrf">
                        <div>
                            <label for="name"> ニックネーム </label>
                            <div>
                                <input id="name" type="text"
                                       class="c-form__input form-control"
                                       name="name" v-bind:value="name" required
                                       autofocus>
                            </div>
                        </div>
                        <div>
                            <label for="email">Emailアドレス </label>
                            <div>
                                <input id="email" type="text"
                                       class="c-form__input form-control "
                                       name="email" v-bind:value="email" required
                                       autofocus>


                            </div>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form">
                                <div>
                                    <button type="submit" formaction="/profile/edit">
                                        更新する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form">
                                <div>
                                    <button type="submit" formaction="/profile/withdraw">
                                        退会する
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
            axios.get('/home/json/name').then(response => {
                this.name = response.data;
            })
            axios.get('/home/json/email').then(response => {
                this.email = response.data;
            })
        })
    },
    methods: {
        checkForm: function (e) {
            if (this.name && this.email) {
                return true;
            }

            this.errors = [];

            if (!this.name || !this.email) {
                this.errors.push('全て入力必須項目です');
            }
            e.preventDefault();
        }
    },
    data: function () {
        return {
            name: [],
            email: [],
            errors: []
        }
    }
}
</script>
