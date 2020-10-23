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

            <el-row>
                <el-input class="search_input"
                          placeholder="Найти новость по заголовку..."
                          v-model="newsSearch"
                          v-on:change="checkNewsTitle()"
                ></el-input>
                <el-button icon="el-icon-search" circle v-on:click="checkNewsTitle()"></el-button>
            </el-row>

            <el-button type="primary" @click="dialogVisible = true">Фильтры</el-button>

            <el-dialog
                title="Фильтры:"
                :visible.sync="dialogVisible"
            >
                <el-row>
                    <el-col :span="6" :offset="1">
                        <p class="demonstration">Автор: </p>
                        <el-select v-model="author" placeholder="Выберите автора">
                            <el-option
                                :key="0"
                                label="Все авторы"
                                :value="0">
                            </el-option>
                            <el-option
                                v-for="item in authors"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-col>
                    <el-col :span="6" :offset="1">
                        <div class="block">
                            <p class="demonstration">Дата от: </p>
                            <el-date-picker
                                v-model="dateFrom"
                                type="date"
                                value-format="yyyy-MM-dd"
                                placeholder="Выберите день">
                            </el-date-picker>
                        </div>
                    </el-col>
                    <el-col :span="6" :offset="1">
                        <div class="block">
                            <p class="demonstration">Дата до:</p>
                            <el-date-picker
                                v-model="dateTo"
                                type="date"
                                value-format="yyyy-MM-dd"
                                placeholder="Выберите день">
                            </el-date-picker>
                        </div>
                    </el-col>
                </el-row>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogVisible = false">Отменить</el-button>
                    <el-button type="primary" v-on:click="filterOut()">Применить</el-button>
                </span>
            </el-dialog>

            <el-table v-if="tableNews" :data="tableNews">
                <el-table-column prop="name" label="Название" width="300">
                    <template slot-scope="scope">
                        <router-link
                            tag="el-link"
                            :to="'/news/' + scope.row.id"
                            :key="scope.row.id"
                        >
                            {{scope.row.name}}
                            <i class="el-icon-view el-icon--right"></i>
                        </router-link>
                    </template>
                </el-table-column>
                <el-table-column prop="date" label="Дата" width="150"></el-table-column>
                <el-table-column prop="author_name" label="Автор" width="150"></el-table-column>
                <el-table-column prop="announce" label="Краткое описание"></el-table-column>
            </el-table>

            <ul v-if="links" class="el-pager">
                <li
                    v-for="{ label, url } in links"
                    v-if="label === currentPage"
                    class="number active"
                    v-on:click="pagination({url})">
                    {{ label }}
                </li>
                <li
                    v-else
                    class="number"
                    v-on:click="pagination({url})">
                    {{ label }}
                </li>
            </ul>

        </el-col>
    </el-row>
</template>

<script>
    export default {
        computed: {
            authors () {
                return this.$store.state.authors
            },
            links () {
                return this.$store.state.links
            },
            tableNews () {
                return this.$store.state.tableNews
            },
            currentPage () {
                return this.$store.state.currentPage
            },
            error () {
                return this.$store.state.error
            },
        },
        data() {
            return {
                author: null,
                dateFrom: null,
                dateTo: null,
                dialogVisible: false,
                newsSearch: null,
                queryParams: '?',
            };
        },
        created() {
            this.fetchData();
        },
        beforeUpdate() {
            this.links[0].label = '<';
            this.links[this.links.length - 1].label = '>';
        },
        methods: {
            fetchData() {
                this.$store.commit('getListNews', '/api/newsList' + this.$route.fullPath);
            },
            pagination(page) {
                this.$router.push({path: this.queryParams, query: {page: page.url.slice(-1)}})
                this.fetchData();
            },
            filterOut() {
                this.queryParams = '/?';
                if (this.author !== null) {
                    this.$router.push({path: this.queryParams, query: {author: this.author}})
                    this.queryParams += '&author=' + this.author;
                }
                if (this.dateFrom !== null) {
                    this.$router.push({path: this.queryParams, query: {dateFrom: this.dateFrom}})
                    this.queryParams += '&dateFrom=' + this.dateFrom;
                }
                if (this.dateTo !== null) {
                    this.$router.push({path: this.queryParams, query: {dateTo: this.dateTo}})
                    this.queryParams += '&dateTo=' + this.dateTo;
                }
                this.dialogVisible = false;
                this.newsSearch = '';
                this.fetchData();
            },
            checkNewsTitle() {
                if (this.newsSearch !== null) {
                    this.$router.push({path: this.queryParams, query: {newsSearch: this.newsSearch}})
                }
                this.fetchData();
            },
        }
    }
</script>

<style>
    .search_input {
        width: 30%;
        margin: 10px 0
    }

    .el-pager {
        margin: 10px 0;
    }

    .el-pager li {
        font-size: 16px;
    }
</style>
