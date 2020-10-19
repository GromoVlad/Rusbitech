<template>
    <div class="container">
        <el-row>
            <el-col :span="18" :offset="3">
                <h1>Vue Single Page Application</h1>
                <a href="http://rusbitech/api/documentation">Документация</a>
                <hr>
            </el-col>
        </el-row>
        <router-view></router-view>
    </div>
</template>
<script>
    export default {}
</script>
