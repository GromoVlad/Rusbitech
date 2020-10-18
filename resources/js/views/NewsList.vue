<template>
    <el-row>
        <el-col :span="18" :offset="3">
            <div class="grid-content bg-purple-dark">



        <div v-if="error" class="error">
            {{ error }}
            <p>
                <button @click.prevent="fetchData">
                    Попробовать снова!
                </button>
            </p>
        </div>

        <el-input style="width: 30%; margin: 10px 0" placeholder="Найти новость по заголовку..."
                  v-model="newsSearch"
                  v-on:change="checkNewsTitle()"
        ></el-input>

        <el-button type="primary" @click="dialogVisible = true">Фильтры</el-button>
        <el-dialog
            title="Фильтры:"
            :visible.sync="dialogVisible"
            width="50%"
            >
            <div>
                <el-select v-model="author" placeholder="Автор">
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

                <div class="block">
                    <span class="demonstration">От: </span>
                    <el-date-picker
                        v-model="date_from"
                        type="date"
                        value-format="yyyy-MM-dd"
                        placeholder="Выберите день">
                    </el-date-picker>
                </div>

                <div class="block">
                    <span class="demonstration">До: </span>
                    <el-date-picker
                        v-model="date_to"
                        type="date"
                        value-format="yyyy-MM-dd"
                        placeholder="Выберите день">
                    </el-date-picker>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Отменить</el-button>
                <el-button type="primary" v-on:click="filter_out()">Применить</el-button>
            </span>
        </el-dialog>
<!--
        <h3>Фильтр по категориям:</h3>

        <el-select v-model="author" placeholder="Автор">
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

        <div class="block">
            <span class="demonstration">От: </span>
            <el-date-picker
                v-model="date_from"
                type="date"
                value-format="yyyy-MM-dd"
                placeholder="Выберите день">
            </el-date-picker>
        </div>

        <div class="block">
            <span class="demonstration">До: </span>
            <el-date-picker
                v-model="date_to"
                type="date"
                value-format="yyyy-MM-dd"
                placeholder="Выберите день">
            </el-date-picker>
        </div>

        <button v-on:click="filter_out()" class="btn btn btn-outline-info">
            Фильтр
        </button>
-->

    <el-table v-if="tableNews" :data="tableNews" style="width: 100%">
        <el-table-column prop="name" label="Название" width="300"></el-table-column>
        <el-table-column prop="date" label="Дата" width="150"></el-table-column>
        <el-table-column prop="author_name" label="Автор" width="150"></el-table-column>
        <el-table-column prop="announce" label="Краткое описание"></el-table-column>
    </el-table>

<!--
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
-->

        <ul class="el-pager" v-if="links" style="font-size: 16px">
            <li class="number" v-for="{ label, url } in links" v-on:click="pagination({url})">
                {{ label }}
            </li>
        </ul>

            </div></el-col>
        </el-row>


</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                url: '/api/newsList',
                authors: null,
                author: null,
                error: null,
                links: null,
                date_from: null,
                date_to: null,
                tableNews: null,
                dialogVisible: false,
                newsSearch: null,
                queryParams: '?',
            };
        },
        created() {
            this.fetchData();
        },
        beforeUpdate() {
            console.log(this.$route.fullPath);
        },
        methods: {
            fetchData() {
                this.error = this.tableData = null;
                axios
                    .get(this.url + this.$route.fullPath)
                    .then(response => {
                       // console.log(response);
                        this.authors = response.data.authors;
                        this.links = response.data.list.links;
                        this.tableNews = response.data.list.data;
                    }).catch(error => {
                    this.error = error.response.data.message || error.message;
                });
            },
            pagination(page) {
             //   const delPage = /&page=[^&]+/i;
             //   this.url = this.url.replace(delPage, '');
             //   this.url = this.url + '&page=' + page.url.slice(-1);
               // this.queryParams = this.queryParams.replace(delPage, '');
              //  this.queryParams += '&page=' + page.url.slice(-1);
                this.$router.push({ path: this.queryParams, query: { page : page.url.slice(-1) } })
                this.fetchData();
            },
            filter_out() {
             //   this.url = '/api/newsList/?';
                this.queryParams = '/?';
                if (this.author !== null) {
                //    this.url = this.url + '&author=' + this.author;
                    this.queryParams += '&author=' + this.author;
                    this.$router.push({ path: this.queryParams, query: { author : this.author } })
                }
                if (this.date_from !== null) {
               //     this.url = this.url + '&date_from=' + this.date_from;
                    this.queryParams += '&date_from=' + this.date_from;
                    this.$router.push({ path: this.queryParams, query: { date_from : this.date_from } })
                }
                if (this.date_to !== null) {
              //      this.url = this.url + '&date_to=' + this.date_to;
                    this.queryParams += '&date_to=' + this.date_to;
                    this.$router.push({ path: this.queryParams, query: { date_to : this.date_to } })
                }
                this.fetchData();
                this.dialogVisible = false;
                this.newsSearch = '';
             //   this.$router.push({ path: '/', query: { plan: 'private' } })
                //this.$router.push({ path: '/', query: { plan : this.queryParams } })
               // this.$router.push({ path: '/', query: 'two'  })
            },
            checkNewsTitle() {
              //  console.log(this.newsSearch);
            //    this.url = '/api/newsList/?';
                if (this.newsSearch !== null) {
               //     this.url = this.url + '&newsSearch=' + this.newsSearch;
                    this.queryParams += '&newsSearch=' + this.newsSearch;
                    this.$router.push({ path: this.queryParams, query: { newsSearch : this.newsSearch } })
                }
                this.fetchData();
            }
        }
    }
</script>
