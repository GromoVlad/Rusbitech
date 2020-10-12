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



    </div>
</template>
<script>
    import axios from 'axios';



    export default {
        data() {
            return {
                loading: false,
                news: null,
                error: null,
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.news = null;
                this.loading = true;
                axios
                    .get('/api/newsList')
                    .then(response => {
                    //    console.log(response.data.list);
                        this.news = response.data.list.data;
                        this.loading = false;
                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            }
        }
    }
</script>
