import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'
import NewsList from './views/NewsList'
import News from './views/News'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'newsList',
            component: NewsList,
        },
        {
            path: '/news/:id',
            name: 'news',
            component: News,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
