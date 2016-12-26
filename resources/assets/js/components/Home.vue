<template>
    <div class="container">
        <h1>从很久以前就喜欢你了。～告白实行委员会～</h1>
        <p>
            <a href="http://bangumi.bilibili.com/anime/v/96536" target="_blank">
                <img src="http://i2.hdslb.com/bfs/archive/a7f0f45e5bbe0954029ce210c8d0fc39e17f2a39.jpg">
            </a>
        </p>

        <div class="content">
            <div>
                <router-link to="/blog">
                    <button>进入博客</button>
                </router-link>
                <router-link to="/about">
                    <button>关于我</button>
                </router-link>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
    .container {
        margin-top: 150px;
        text-align: center;

        img {
            height: 240px;
            opacity: .5;
        }
    }
</style>
<script>
    export default{

    }
</script>
