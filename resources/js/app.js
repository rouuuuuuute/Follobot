/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('sidebar', require('./components/Sidebar.vue').default);
Vue.component('follow-keywords', require('./components/FollowKeywords.vue').default);
Vue.component('favorites', require('./components/Favorites.vue').default);
Vue.component('tweets', require('./components/Tweets.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('targets', require('./components/Targets.vue').default);
Vue.component('accounts', require('./components/TwitterAccounts.vue').default);
Vue.component('home', require('./components/Home.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const sidebar = new Vue({
    el: '#js-sidebar'
});

const follow_keywords = new Vue({
    el: '#js-follow_keywords'
});

const favorites = new Vue({
    el: '#js-favorites'
});

const tweets = new Vue({
    el: '#js-tweets'
});

const home = new Vue({
    el: '#js-home'
});

const profile = new Vue({
    el: '#js-profile'
});

const targets = new Vue({
    el: '#js-targets'
});

const accounts = new Vue({
    el: '#js-accounts'
});


//aaa
