<template>
    <el-row>
        <el-col :span="18" :offset="3">
            <div v-if="error" class="error">
                {{ error }}
                <p>
                    <button @click.prevent="fetchData">
                        Попробовать снова!
                    </button>
                </p>
            </div>

            <el-row>
                <el-input style="width: 30%; margin: 10px 0"
                          placeholder="Найти новость по заголовку..."
                          v-model="newsSearch"
                          v-on:change="checkNewsTitle()"
                ></el-input>
            </el-row>

            <el-button type="primary" @click="dialogVisible = true">Фильтры</el-button>

            <el-dialog
                title="Фильтры:"
                :visible.sync="dialogVisible"
                width="50%"
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

            <el-table v-if="tableNews" :data="tableNews" style="width: 100%">
                <el-table-column prop="name" label="Название" width="300">
                    <template slot-scope="scope">
                        <router-link
                            :to="'/news/' + scope.row.id"
                            :key="scope.row.id"
                        >{{scope.row.name}}
                        </router-link>
                    </template>
                </el-table-column>
                <el-table-column prop="date" label="Дата" width="150"></el-table-column>
                <el-table-column prop="author_name" label="Автор" width="150"></el-table-column>
                <el-table-column prop="announce" label="Краткое описание"></el-table-column>
            </el-table>

            <ul v-if="links" class="el-pager" style="margin: 10px 0">
                <li
                    style="font-size: 16px"
                    v-for="{ label, url } in links"
                    v-if="label === currentPage"
                    class="number active"
                    v-on:click="pagination({url})">
                    {{ label }}
                </li>
                <li
                    v-else
                    style="font-size: 16px"
                    class="number"
                    v-on:click="pagination({url})">
                    {{ label }}
                </li>
            </ul>
        </el-col>
    </el-row>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                authors: null,
                author: null,
                error: null,
                links: null,
                dateFrom: null,
                dateTo: null,
                tableNews: null,
                dialogVisible: false,
                newsSearch: null,
                queryParams: '?',
                currentPage: null,
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
                this.error = this.tableData = null;
                axios
                    .get('/api/newsList' + this.$route.fullPath)
                    .then(response => {
                        this.authors = response.data.authors;
                        this.links = response.data.list.links;
                        this.tableNews = response.data.list.data;
                        this.currentPage = response.data.list.current_page;
                    }).catch(error => {
                    this.error = error.response.data.message || error.message;
                });
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
            }
        }
    }
</script>
