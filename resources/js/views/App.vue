<template>
    <div class="container">
        <h1>Vue Single Page Application </h1>
        <p>
            <router-link :to="{ name: 'newsList' }">Все новости</router-link>
        </p>
        <router-view></router-view>
    </div>
</template>
<script>
    export default {}
</script>
