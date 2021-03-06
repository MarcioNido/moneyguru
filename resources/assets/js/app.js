
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import router from './router';

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

Vue.use(VueRouter);
Vue.use(Vuex);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('guru-nav-bar', require('./components/GuruNavBar.vue'));

const store = new Vuex.Store({
    state: {
        count: 0,
        isAuth: false,
    },
    mutations: {
        increment (state) {
            state.count++
        },
        setAuth (state, data) {
            state.isAuth = data;
        }
    }
});


const app = new Vue({
    el: '#app',
    store,
    router
});
