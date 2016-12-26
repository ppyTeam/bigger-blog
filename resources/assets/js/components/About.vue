<template>
    <div id="about">
        <h1>这是 About 页面</h1>
        <h4>路由位置：{{ $route.fullPath }}</h4>

        <hr>
        <a href="#" @click.prevent="goBack">Go Back</a>
        <router-link to="/">Home</router-link>
        <router-link to="/blog">Blog</router-link>
        <a href="https://github.com/ppyTeam/bigger-blog/tree/dev" target="_blank">Github</a>
    </div>
</template>
<style>
#about {
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
