<template>
    <div class="users">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
            <p>
                <button @click.prevent="fetchData">
                    Try Again
                </button>
            </p>
        </div>

        <ul v-if="news">
            <li v-for="{ name, announce, date, author_name } in news">
                <strong>Название:</strong> {{ name }}, <br>
                <strong>Дата создания:</strong> {{ date }}, <br>
                <strong>Автор:</strong> {{ author_name }}, <br>
                <strong>Краткое описание:</strong> {{ announce }} <br>
            </li>
        </ul>

        <ul v-if="links">
            <li v-for="{ label, url } in links">
                <a v-on:click="pagination({url})">{{ label }}</a>
            </li>
        </ul>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                url: '/api/newsList/?',
                loading: false,
                news: null,
                error: null,
                links: null,
            };
        },
        created() {
            this.fetchData();
          //  console.log(this.current_page);
        },
        beforeUpdate() {
        },
        methods: {
            fetchData() {
                this.error = this.news = null;
                this.loading = true;
                axios
                    .get(this.url)
                    .then(response => {
                        this.news = response.data.list.data;
                        this.links = response.data.list.links;
                        this.loading = false;
                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
            pagination(page) {
                let delPage = /&page=[^&]+/i;
                this.url = this.url.replace(delPage, '');
                let page_url = page.url.slice(-1);
                this.url = this.url + '&page=' + page_url;
                this.fetchData();
            }
        }
    }
</script>
