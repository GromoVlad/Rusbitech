import Vue from 'vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/ru-RU'
import store from  './store'

Vue.use(VueRouter)
Vue.use(ElementUI, { locale })

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
    store,
});
