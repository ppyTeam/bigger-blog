<template>
    <div>
        <h1>这是 About 页面</h1>
        <h4>路由位置：{{ $route.fullPath }}</h4>

        <hr>
        <a href="#" @click.prevent="goBack">后退</a>
        <router-link to="/">Home</router-link>
        <router-link to="/blog">Blog</router-link>
    </div>
</template>
<style scoped>
div {
    text-align: center;
}
</style>
<script>
    export default {
        data() {
            return {

            }
        },
        methods: {
            goBack: function() {
                history.go(-1);
            }
        }
    }
</script>
