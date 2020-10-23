<template>
    <el-row>
        <el-col :span="18" :offset="3">

            <div v-if="error" class="error">
                {{ error }}
                <br>
                <button @click.prevent="fetchData">
                    Попробовать снова!
                </button>
            </div>

            <div v-if="news">
                <el-col :span="18">
                    <el-card header="Статья" class="box-card">
                        <p><strong>Название:</strong></p>
                        <p>{{ news.name }}</p>
                        <p><strong>Дата создания:</strong></p>
                        <router-link :to="'/?dateFrom=' + news.date + '&dateTo=' + news.date" tag="el-link">
                            {{ news.date }}<i class="el-icon-view el-icon--right"></i>
                        </router-link>
                        <p><strong>Подробное описание:</strong></p>
                        <p>{{ news.content }}</p>
                        <router-link :to="{ name: 'newsList' }">
                            <el-button type="primary" icon="el-icon-arrow-left">К новостям</el-button>
                        </router-link>
                    </el-card>
                </el-col>
                <el-col :span="4" :offset="1">
                    <el-card header="Данные о авторе" class="box-card">
                        <router-link :to="'/?author=' + news.author_id" tag="el-link">
                            <strong>Автор:</strong> {{ news.author_name }}<i class="el-icon-view el-icon--right"></i>
                        </router-link>
                        <p><strong>Рейтинг издания:</strong> {{ news.rating }}</p>
                        <router-link :to="'/?author=' + news.author_id" tag="el-link">
                            <strong>Количество статей:</strong> {{ news.count_news }}<i class="el-icon-view el-icon--right"></i>
                        </router-link>
                    </el-card>
                </el-col>
            </div>
        </el-col>
    </el-row>
</template>
<script>
    export default {
        computed: {
            news () {
                return this.$store.state.news
            },
            error () {
                return this.$store.state.error
            },
        },
        data () {
            return {
                id: this.$router.currentRoute.params['id'],
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
                this.$store.commit('getNews', '/api/news/' + this.id);
            },
        }
    }
</script>
