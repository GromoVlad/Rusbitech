<template>
    <div class="container">
        <el-row>
            <el-col :span="18" :offset="3">
                <el-link :underline="false" href="/" class="title">Тестовое задание "РусБИТех"</el-link>
                <el-link :underline="false" href="/api/documentation" class="docs">Документация</el-link>
                <hr>
            </el-col>
        </el-row>
        <router-view></router-view>
    </div>
</template>
<script>
    export default {
    }
</script>

<style>
    .title{
        width: 100%;
        font-size: 32px;
        margin: 15px 0;
        justify-content: flex-start;
    }
    .docs{
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>
