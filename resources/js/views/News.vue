<template>
    <el-row>
        <el-col :span="18" :offset="3">
            <div v-if="news">
                <el-col :span="18">
                    <el-card header="Статья" class="box-card">
                        <p><strong>Название:</strong> {{ news.name }}</p>
                        <p><strong>Дата создания:</strong> {{ news.date }}</p>
                        <p><strong>Подробное описание:</strong> {{ news.content }}</p>
                        <router-link :to="{ name: 'newsList' }">
                            <el-page-header title="К новостям"></el-page-header>
                        </router-link>
                    </el-card>
                </el-col>
                <el-col :span="4" :offset="1">
                    <el-card header="Данные о авторе" class="box-card">
                        <strong>Автор:</strong> {{ news.author_name }}<br>
                        <strong>Рейтинг издания:</strong> {{ news.rating }}<br>
                        <strong>Количество статей:</strong> {{ news.count_news }}<br>
                    </el-card>
                </el-col>
            </div>
        </el-col>
    </el-row>
</template>
<script>
    import axios from 'axios';

    export default {
        data () {
            return {
                id: this.$router.currentRoute.params['id'],
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
                axios
                    .get('/api/news/' + this.id)
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
