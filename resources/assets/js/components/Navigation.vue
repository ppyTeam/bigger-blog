<template>
    <div class="sidebar nav-sidebar">
        <router-link to="/">
            <img class="logo" src="http://ttionya.qiniudn.com/LOGO.gif" />
        </router-link>
        <nav>
            <ul>
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/blog">Blog</router-link></li>
                <li><router-link to="/blog/page/2">Page 2</router-link></li>
                <li><router-link to="/blog/3">Post 3</router-link></li>
                <li><router-link to="/categories">Categories</router-link></li>
                <li><router-link to="/category/games">Category Game</router-link></li>
                <li><router-link to="/tags">Tags</router-link></li>
                <li><router-link to="/tag/steam">Tag Steam</router-link></li>
                <li><router-link to="/archives">Archives</router-link></li>
                <li><router-link to="/about">About</router-link></li>
            </ul>
        </nav>
    </div>
</template>
<style lang="scss">
.sidebar {
    position: fixed;
    height: 100%;
    width: 300px;
    background-color: #fff;
    opacity: .8;
}
.nav-sidebar {
    .logo {
        display: block;
        width: 112px;
        margin: 50px auto;
        border: 1px #DDD solid;
        border-radius: 500px;
        background-color: #fff;
    }

    ul {
        font-size: 2rem;
        list-style: none;

        li {
            margin: 5px;
        }
    }
}
</style>
<script>
    export default{
        //data(){
        //    return{
        //        msg:'hello vue'
        //    }
        //},
        //components:{
        //    'other-component':OtherComponent,
        //    HeaderComponent,
        //}
    }
</script>
