<template>
    <div class="news">
        <ul v-if="news">
            <strong>Название:</strong> {{ news.name }}<br>
            <strong>Дата создания:</strong> {{ news.date }}<br>
            <strong>Подробное описание:</strong> {{ news.content }}<br>
            <strong>Автор:</strong> {{ news.author_name }}<br>
            <strong>Рейтинг издания:</strong> {{ news.rating }}<br>
            <strong>Количество статей:</strong> {{ news.count_news }}<br>
        </ul>
        <router-link :to="{ name: 'newsList' }">&#8592; К новостям</router-link>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        data () {
            return {
                id: this.$router.currentRoute.params['id'],
                url: '/api/news/',
                news: null,
            }
        },
        watch: {
            $route (toR, fromR) {
                this.id = toR.params['id']
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.news = null;
                this.loading = true;
                console.log(this.url + this.id);
                axios
                    .get(this.url + this.id)
                    .then(response => {
                        this.news = response.data;
                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
        }
    }
</script>
