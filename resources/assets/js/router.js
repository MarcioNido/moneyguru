import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./components/Home.vue')
    },

    {
        path: '/about',
        component: require('./components/About.vue')
    },

    {
        path: '/bank-accounts',
        component: require('./components/BankAccounts.vue')
    },

    {
        path: '/categories',
        component: require('./components/Categories.vue')
    },

    {
        path: '/finances',
        component: require('./components/Finances.vue')
    },




];

export default new VueRouter({

    routes

});