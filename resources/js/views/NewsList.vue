<template>
    <div class="news">
        <div v-if="error" class="error">
            {{ error }}
            <p>
                <button @click.prevent="fetchData">
                    Попробовать снова!
                </button>
            </p>
        </div>

        <h3>Фильтр по категориям:</h3>
        <div style="display: flex; margin: 10px 0">
            <div v-if="authors" style="display: flex; align-items: center">
                <div style="margin-right: 10px;">Автор:</div>
                <label>
                    <select v-model="author" name="author">
                        <option selected value="0">Все авторы</option>
                        <option v-for="{ id, name } in authors" v-bind:value="id">{{ name }}</option>
                    </select>
                </label>
            </div>
            <div style="display: flex; align-items: center">
                <div style="margin: 0 20px;">От:</div>
                <input v-model="date_from" type="date" class="form-control" name="date_from" placeholder="Дата от:">
            </div>
            <div style="display: flex; align-items: center">
                <div style="margin: 0 20px;">До:</div>
                <input v-model="date_to" type="date" class="form-control" name="date_to" placeholder="Дата до:">
            </div>
            <button v-on:click="filter_out()"
                class="btn btn btn-outline-info" style="margin: 0 20px;">Фильтр</button>
        </div>


        <ul v-if="news">
            <li v-for="{ id, name, announce, date, author_name } in news">
                <router-link
                    :to="'/news/' + id"
                    :key="id"
                >
                    <strong>Название:</strong> {{ name }}
                </router-link><br>
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
    //date_from=2020-10-07&date_to=2020-10-12
    export default {
        data() {
            return {
                url: '/api/newsList/?',
                news: null,
                authors: null,
                author: null,
                error: null,
                links: null,
                date_from: null,
                date_to: null,
            };
        },
        created() {
            this.fetchData();
          //  console.log(this.current_page);
        },
        beforeUpdate() {
           // console.log('дата от:' + this.date_from);
          //  console.log('дата до:' + this.date_to);
           // console.log(this.authors);
            console.log(this.url);
        },
        methods: {
            fetchData() {
                this.error = this.news = null;
                axios
                    .get(this.url)
                    .then(response => {
                        this.authors = response.data.authors;
                        this.news = response.data.list.data;
                        this.links = response.data.list.links;
                    }).catch(error => {
                    this.error = error.response.data.message || error.message;
                });
            },
            pagination(page) {
                const delPage = /&page=[^&]+/i;
                this.url = this.url.replace(delPage, '');
                this.url = this.url + '&page=' + page.url.slice(-1);
                this.fetchData();
            },
            filter_out() {
                this.url = '/api/newsList/?';
                if (this.author !== null) {
                    this.url = this.url + '&author=' + this.author;
                }
                if (this.date_from !== null) {
                    this.url = this.url + '&date_from=' + this.date_from;
                }
                if (this.date_to !== null) {
                    this.url = this.url + '&date_to=' + this.date_to;
                }
                this.fetchData();
            }
        }
    }
</script>
