import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        authors: null,
        links: null,
        tableNews: null,
        currentPage: null,
        error: null,
        news: null,
    },
    mutations: {
        getListNews (state, queryURI) {
            state.error = state.tableNews = null;
            axios
                .get(queryURI)
                .then(response => {
                    state.authors = response.data.authors;
                    state.links = response.data.list.links;
                    state.tableNews = response.data.list.data;
                    state.currentPage = response.data.list.current_page;
                }).catch(error => {
                state.error = error.response.data.message || error.message;
            });
        },
        getNews (state, queryURI) {
            state.error = state.news = null;
            axios
                .get(queryURI)
                .then(response => {
                    state.news = response.data;
                }).catch(error => {
                state.error = error.response.data.message || error.message;
            });

        }
    },
})
